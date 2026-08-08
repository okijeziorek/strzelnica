<?php
/**
 * Verifies that the public theme surface remains editable with native blocks.
 */

/**
 * Fails the contract test with a useful message.
 *
 * @param bool   $condition Assertion result.
 * @param string $message   Failure description.
 * @return void
 */
function gro_editability_assert( $condition, $message ) {
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
}

/**
 * Reads a repository file used as a local test fixture.
 *
 * @param string $path Path relative to the repository root.
 * @return string
 */
function gro_read_fixture( $path ) {
	$absolute_path = dirname( __DIR__ ) . '/' . ltrim( $path, '/' );

	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local test fixture, not a runtime request.
	$content = file_get_contents( $absolute_path );
	gro_editability_assert( false !== $content, 'Cannot read fixture: ' . $path );

	return (string) $content;
}

$editable_files = array_merge(
	glob( dirname( __DIR__ ) . '/templates/*.html' ),
	glob( dirname( __DIR__ ) . '/parts/*.html' )
);
$forbidden      = array(
	'"templateLock"',
	'"lock"',
	'"contentOnly"',
	'<!-- wp:html',
);

foreach ( $editable_files as $editable_file ) {
	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local test fixture, not a runtime request.
	$markup = file_get_contents( $editable_file );
	gro_editability_assert( false !== $markup, 'Cannot read editable template: ' . basename( $editable_file ) );
	gro_editability_assert( false !== strpos( $markup, '<!-- wp:' ), 'Template must contain native blocks: ' . basename( $editable_file ) );

	foreach ( $forbidden as $forbidden_token ) {
		gro_editability_assert( false === strpos( $markup, $forbidden_token ), 'Editor lock found in ' . basename( $editable_file ) . ': ' . $forbidden_token );
	}
}

$front_page = gro_read_fixture( 'templates/front-page.html' );
$header     = gro_read_fixture( 'parts/header.html' );
$footer     = gro_read_fixture( 'parts/footer.html' );
$migration  = gro_read_fixture( 'inc/legacy-migration.php' );
$functions  = gro_read_fixture( 'functions.php' );

gro_editability_assert( false !== strpos( $front_page, '<!-- wp:post-content' ), 'Front page content must be edited as post content.' );
gro_editability_assert( false !== strpos( $header, '<!-- wp:image' ) || false !== strpos( $header, '<!-- wp:site-logo' ), 'Header logo must be a native editable block.' );
gro_editability_assert( false !== strpos( $header, '<!-- wp:navigation' ), 'Header menu must use the Navigation block.' );
gro_editability_assert( false !== strpos( $header, '<!-- wp:button' ), 'Header call to action must use the Button block.' );
gro_editability_assert( false !== strpos( $footer, '<!-- wp:columns' ), 'Footer must use editable Column blocks.' );
gro_editability_assert( false === strpos( $functions, 'register_block_type' ), 'Visible content must not depend on custom dynamic blocks.' );
gro_editability_assert( false !== strpos( $migration, 'if ( $navigation_id ) {' ), 'Migration must preserve an existing Navigation entity.' );
gro_editability_assert( false !== strpos( $migration, 'if ( $template_id ) {' ), 'Migration must preserve an existing header template part.' );
gro_editability_assert( false !== strpos( $migration, 'if ( $stored_version < 6 ) {' ), 'Only legacy front pages may receive the compatibility upgrade.' );

echo "Editability contract passed.\n";
