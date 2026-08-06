<?php
/**
 * Lightweight smoke test for block serialization and migration idempotence.
 */

define( 'ABSPATH', __DIR__ );

function add_action() {}
function __( $text ) {
	return $text;
}
function esc_html__( $text ) {
	return esc_html( $text );
}
function esc_html( $text ) {
	return htmlspecialchars( (string) $text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' );
}
function esc_attr( $text ) {
	return esc_html( $text );
}
function esc_url( $url ) {
	return (string) $url;
}
function wp_kses_post( $text ) {
	return (string) $text;
}
function wp_json_encode( $value, $flags = 0 ) {
	return json_encode( $value, $flags );
}
function sanitize_html_class( $class ) {
	return preg_replace( '/[^A-Za-z0-9_-]/', '', (string) $class );
}
function absint( $value ) {
	return abs( (int) $value );
}
function get_theme_file_uri( $path ) {
	return 'https://example.test/theme/' . ltrim( $path, '/' );
}

require dirname( __DIR__ ) . '/inc/legacy-migration.php';

function gro_test_assert( $condition, $message ) {
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
}

$hero = gro_build_hero_blocks(
	array(
		'title'         => "Poczuj emocje.\nGun Resort.",
		'text'          => 'Opis',
		'offer_label'   => 'Zobacz pakiety',
		'offer_url'     => '#pakiety',
		'booking_label' => 'Rezerwuj',
		'booking_url'   => '#kontakt',
		'image_id'      => 0,
		'image_url'     => get_theme_file_uri( 'hero.jpg' ),
		'image_alt'     => '',
	)
);
$packages = gro_build_packages_blocks();
$steps    = gro_build_first_time_blocks();
$legacy   = gro_build_features_blocks(
	array(
		array(
			'title' => 'Zaleta',
			'text'  => 'Opis',
		),
	),
	'Dlaczego Gun Resort?'
);
$upgraded = gro_upgrade_front_page_content( $legacy );

gro_test_assert( false !== strpos( $hero, '<!-- wp:cover' ), 'Hero must use the Cover block.' );
gro_test_assert( false !== strpos( $hero, 'href="#kontakt"' ), 'Hero booking must target contact.' );
gro_test_assert( 4 === substr_count( $packages, '<div class="wp-block-group gro-package-card">' ), 'Four package cards are required.' );
gro_test_assert( 3 === substr_count( $steps, '<div class="wp-block-group gro-step">' ), 'Three first-visit steps are required.' );
gro_test_assert( false !== strpos( $upgraded, 'id="dlaczego"' ), 'Benefits need the #dlaczego anchor.' );
gro_test_assert( false !== strpos( $upgraded, 'gro-packages' ), 'Upgrade must append packages.' );
gro_test_assert( false !== strpos( $upgraded, 'gro-first-time' ), 'Upgrade must append first-visit steps.' );
gro_test_assert( $upgraded === gro_upgrade_front_page_content( $upgraded ), 'Upgrade must be idempotent.' );

echo "Block builder smoke test passed.\n";
