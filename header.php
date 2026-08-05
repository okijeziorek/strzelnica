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
                    <svg viewBox="0 0 90 64">
                        <defs>
                            <clipPath id="gun-resort-logo-ring"><circle cx="25" cy="32" r="23"/></clipPath>
                        </defs>
                        <g class="logo-ring-lines" clip-path="url(#gun-resort-logo-ring)">
                            <path d="M-8 18 25-8M-4 29 39-5M-2 40 51-3M1 51 58 6M7 59 62 16M18 65 66 27M31 67 66 39"/>
                        </g>
                        <circle class="logo-ring-outline" cx="25" cy="32" r="23"/>
                        <g class="logo-glock">
                            <path class="logo-glock-slide" d="M8 15h66l9 5v11H8z"/>
                            <path class="logo-glock-frame" d="M13 31h54l-4 7H44l-5-4H13z"/>
                            <path class="logo-glock-grip" d="M15 34h25l-4 27H7z"/>
                            <path class="logo-glock-guard" d="M40 35h22c0 9-6 14-16 14h-6"/>
                            <path class="logo-glock-trigger" d="m48 38-4 7"/>
                            <path class="logo-glock-detail" d="M14 21h62M16 16v-4h7v4M70 15v-3h7v4M17 24h8M17 28h8M55 19h16v7H55z"/>
                        </g>
                    </svg>
                </span>
                <span class="brand-text"><b>Gun</b><strong>Resort</strong></span>
            </a>
        <?php endif; ?>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu" aria-label="<?php echo esc_attr(gro_dynamic_setting('gro_open_menu_label')); ?>"><span></span><span></span><span></span></button>
        <nav class="primary-nav" id="primary-menu" aria-label="<?php esc_attr_e('Menu główne', 'gun-resort-one'); ?>">
            <?php wp_nav_menu(['theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-list', 'fallback_cb' => 'gro_primary_menu_fallback', 'depth' => 1]); ?>
        </nav>
        <?php if (gro_dynamic_setting('gro_booking_label')) : ?><a class="button button-small nav-cta" href="<?php echo esc_url(home_url('/#rezerwacja')); ?>"><?php echo esc_html(gro_dynamic_setting('gro_booking_label')); ?></a><?php endif; ?>
    </div>
</header>
<main id="main">
