<?php
/**
 * Theme bootstrap.
 *
 * @package GunResortOne
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GRO_THEME_VERSION', '2.4.0' );
define( 'GRO_BLOCK_MIGRATION_VERSION', 8 );
/**
 * Registers theme supports used by the block editor and front end.
 */
function gro_setup() {
	load_theme_textdomain( 'gun-resort-one', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( array( 'main.css', 'editor.css' ) );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 72,
			'width'       => 220,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Kept for one release so the migrator can read menus assigned by version 1.x.
	register_nav_menus(
		array(
			'primary' => __( 'Menu główne', 'gun-resort-one' ),
			'footer'  => __( 'Menu w stopce', 'gun-resort-one' ),
		)
	);
}
add_action( 'after_setup_theme', 'gro_setup' );

/**
 * Adds the theme pattern category.
 */
function gro_register_pattern_category() {
	register_block_pattern_category(
		'gun-resort',
		array( 'label' => __( 'Gun Resort', 'gun-resort-one' ) )
	);
}
add_action( 'init', 'gro_register_pattern_category' );

/**
 * Adds reversible visibility controls to links and buttons in the editor.
 */
function gro_register_block_styles() {
	$hidden_style = array(
		'name'  => 'gro-hidden',
		'label' => __( 'Ukryj element', 'gun-resort-one' ),
	);

	register_block_style( 'core/navigation-link', $hidden_style );
	register_block_style( 'core/button', $hidden_style );
}
add_action( 'init', 'gro_register_block_styles' );

/**
 * Loads the small amount of CSS that complements theme.json.
 */
function gro_enqueue_assets() {
	wp_enqueue_style(
		'gun-resort-one',
		get_theme_file_uri( 'main.css' ),
		array(),
		GRO_THEME_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'gro_enqueue_assets' );

require_once get_theme_file_path( 'inc/legacy-migration.php' );
