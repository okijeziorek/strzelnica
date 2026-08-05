<?php
get_header();
$hero_id = absint(get_theme_mod('gro_hero_image', 0));
$hero_url = $hero_id ? wp_get_attachment_image_url($hero_id, 'full') : '';
$features = gro_dynamic_items('gro_feature');
?>

<?php if ($hero_url || gro_dynamic_setting('gro_hero_title') || gro_dynamic_setting('gro_hero_text')) : ?>
<section class="hero-panel" id="oferta"<?php if ($hero_url) : ?> style="<?php echo esc_attr("--hero-image:url('" . esc_url($hero_url) . "')"); ?>"<?php endif; ?>>
    <div class="hero-content">
        <?php if (gro_dynamic_setting('gro_hero_title')) : ?><h1><?php echo nl2br(esc_html(gro_dynamic_setting('gro_hero_title'))); ?></h1><?php endif; ?>
        <?php if (gro_dynamic_setting('gro_hero_text')) : ?><p><?php echo esc_html(gro_dynamic_setting('gro_hero_text')); ?></p><?php endif; ?>
        <div class="hero-actions">
            <?php if (gro_dynamic_setting('gro_offer_label')) : ?><a class="button" href="#pakiety"><?php echo esc_html(gro_dynamic_setting('gro_offer_label')); ?></a><?php endif; ?>
            <?php if (gro_dynamic_setting('gro_booking_label')) : ?><a class="button" href="#rezerwacja"><?php echo esc_html(gro_dynamic_setting('gro_booking_label')); ?></a><?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($features) : ?>
<section class="feature-grid" id="pakiety" aria-label="<?php echo esc_attr(gro_dynamic_setting('gro_features_label')); ?>">
    <?php foreach ($features as $item) : ?>
        <article class="feature-card">
            <?php if (has_post_thumbnail($item)) : ?><div class="line-icon"><?php echo get_the_post_thumbnail($item, 'thumbnail'); ?></div><?php endif; ?>
            <h2><?php echo esc_html(get_the_title($item)); ?></h2>
            <?php echo wp_kses_post(wpautop($item->post_content)); ?>
        </article>
    <?php endforeach; ?>
</section>
<?php endif; ?>
<?php get_footer(); ?>
