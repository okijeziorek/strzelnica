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
            <?php if (gro_dynamic_setting('gro_phone')) : ?>
                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', gro_dynamic_setting('gro_phone'))); ?>">
                    <span class="utility-icon" aria-hidden="true">☎</span>
                    <?php echo esc_html(gro_dynamic_setting('gro_phone')); ?>
                </a>
            <?php endif; ?>
            <?php if (gro_dynamic_setting('gro_top_note')) : ?><span><?php echo esc_html(gro_dynamic_setting('gro_top_note')); ?></span><?php endif; ?>
        </div>
        <div class="utility-right">
            <?php if (gro_dynamic_setting('gro_hours')) : ?><span><?php echo esc_html(gro_dynamic_setting('gro_hours')); ?></span><?php endif; ?>
        </div>
    </div>
    <div class="main-nav-row">
        <?php if (has_custom_logo()) : ?>
            <div class="brand custom-brand"><?php the_custom_logo(); ?></div>
        <?php else : ?>
            <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
                <span class="brand-mark" aria-hidden="true">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/logo-glock.png'); ?>" alt="">
                </span>
                <span class="brand-text"><b>Gun</b><strong>Resort</strong></span>
            </a>
        <?php endif; ?>
        <?php if (gro_ui_feature_enabled('primary_navigation')) : ?>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu" aria-label="<?php echo esc_attr(gro_dynamic_setting('gro_open_menu_label')); ?>"><span></span><span></span><span></span></button>
        <nav class="primary-nav" id="primary-menu" aria-label="<?php esc_attr_e('Menu główne', 'gun-resort-one'); ?>">
            <?php wp_nav_menu(['theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-list', 'fallback_cb' => 'gro_primary_menu_fallback', 'depth' => 1]); ?>
        </nav>
        <?php endif; ?>
        <?php if (gro_ui_feature_enabled('booking_cta') && gro_dynamic_setting('gro_booking_label')) : ?><a class="button button-small nav-cta" href="<?php echo esc_url(home_url('/#rezerwacja')); ?>"><?php echo esc_html(gro_dynamic_setting('gro_booking_label')); ?></a><?php endif; ?>
    </div>
</header>
<main id="main">
