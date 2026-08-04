<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e('Przejdź do treści', 'gun-resort-one'); ?></a>
<div class="site-shell">
<header class="site-header">
    <div class="utility-bar">
        <div class="utility-left">
            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', get_theme_mod('gro_phone', '690 629 112'))); ?>">
                <span class="utility-icon" aria-hidden="true">☎</span>
                <?php echo esc_html(get_theme_mod('gro_phone', '690 629 112')); ?>
            </a>
            <span><span class="utility-icon" aria-hidden="true">◆</span> <?php echo esc_html(get_theme_mod('gro_top_note', 'Najlepsi instruktorzy i bezpieczne tory')); ?></span>
        </div>
        <div class="utility-right">
            <span><?php echo esc_html(get_theme_mod('gro_hours', 'Pn–Pt 10:00–22:00')); ?></span>
            <span><span class="utility-icon" aria-hidden="true">⌖</span> <?php echo esc_html(get_theme_mod('gro_city', 'Toruń')); ?></span>
        </div>
    </div>
    <div class="main-nav-row">
        <?php if (has_custom_logo()) : ?>
            <div class="brand custom-brand"><?php the_custom_logo(); ?></div>
        <?php else : ?>
            <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 64 64" focusable="false"><path d="M10 42a24 24 0 1 1 44 0"/><path d="M17 38l-5-2m10-8-4-4m14-3v-6m10 13 4-4m1 14 5-2"/><path class="needle" d="M32 42l13-16"/><circle cx="32" cy="42" r="3"/></svg>
                </span>
                <span class="brand-text"><b>Gun</b><strong>Resort</strong></span>
            </a>
        <?php endif; ?>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu" aria-label="<?php esc_attr_e('Otwórz menu', 'gun-resort-one'); ?>"><span></span><span></span><span></span></button>
        <nav class="primary-nav" id="primary-menu" aria-label="<?php esc_attr_e('Menu główne', 'gun-resort-one'); ?>">
            <?php wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'nav-list',
                'fallback_cb'    => 'gro_menu_fallback',
                'depth'          => 1,
            ]); ?>
        </nav>
        <a class="button button-small nav-cta js-booking-link" data-service="Strzelnica" href="<?php echo esc_url(gro_section_url('rezerwacja')); ?>"><?php esc_html_e('Zarezerwuj', 'gun-resort-one'); ?></a>
    </div>
</header>
<main id="main">
