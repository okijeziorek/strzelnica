<?php
if (!defined('ABSPATH')) { exit; }

function gro_setup() {
    load_theme_textdomain('gun-resort-one', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('custom-logo', [
        'height' => 72,
        'width' => 220,
        'flex-height' => true,
        'flex-width' => true,
    ]);
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    register_nav_menus([
        'primary' => __('Menu główne', 'gun-resort-one'),
        'footer' => __('Menu w stopce', 'gun-resort-one'),
    ]);
}
add_action('after_setup_theme', 'gro_setup');

function gro_ui_feature_enabled($feature) {
    $settings = [
        'primary_navigation' => 'gro_show_primary_navigation',
        'booking_cta' => 'gro_show_booking_cta',
    ];

    if (!isset($settings[$feature])) {
        return true;
    }

    return (bool) get_theme_mod($settings[$feature], false);
}

function gro_primary_menu_fallback() {
    echo '<ul class="nav-list"><li><a href="#oferta">Oferta</a></li><li><a href="#pakiety">Pakiety</a></li></ul>';
}

require_once get_template_directory() . '/dynamic.php';
