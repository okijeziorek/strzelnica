<?php
get_header();
$status = isset($_GET['booking']) ? sanitize_key(wp_unslash($_GET['booking'])) : '';
$hero_id = absint(get_theme_mod('gro_hero_image', 0));
$hero_url = $hero_id ? wp_get_attachment_image_url($hero_id, 'full') : '';
$features = gro_dynamic_items('gro_feature');
$cards = gro_dynamic_items('gro_card');
$prices = gro_dynamic_items('gro_price');
$services = gro_dynamic_items('gro_service');
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

<?php if ($cards) : ?>
<section class="experience-panel" id="dla-kogo">
    <?php foreach ($cards as $item) : ?>
        <article class="experience-card">
            <?php if (has_post_thumbnail($item)) : echo get_the_post_thumbnail($item, 'large', ['loading' => 'lazy']); endif; ?>
            <div class="experience-body">
                <h2><?php echo esc_html(get_the_title($item)); ?></h2>
                <?php if ($item->post_excerpt) : ?><div class="meta-row"><span><?php echo esc_html($item->post_excerpt); ?></span></div><?php endif; ?>
                <?php echo wp_kses_post(wpautop($item->post_content)); ?>
            </div>
        </article>
    <?php endforeach; ?>
</section>
<?php endif; ?>

<section class="booking-grid">
    <?php if ($prices) : ?>
    <article class="price-card" id="cennik">
        <?php if (gro_dynamic_setting('gro_prices_label')) : ?><h2><?php echo esc_html(gro_dynamic_setting('gro_prices_label')); ?></h2><?php endif; ?>
        <dl><?php foreach ($prices as $item) : ?><div><dt><?php echo esc_html(get_the_title($item)); ?></dt><dd><?php echo esc_html($item->post_excerpt); ?></dd></div><?php endforeach; ?></dl>
    </article>
    <?php endif; ?>

    <article class="form-card" id="rezerwacja">
        <?php if (gro_dynamic_setting('gro_form_label')) : ?><h2><?php echo esc_html(gro_dynamic_setting('gro_form_label')); ?></h2><?php endif; ?>
        <div class="form-feedback" aria-live="polite">
            <?php if ('ok' === $status && gro_dynamic_setting('gro_success_message')) : ?><div class="form-alert success"><?php echo esc_html(gro_dynamic_setting('gro_success_message')); ?></div><?php endif; ?>
            <?php if ('error' === $status && gro_dynamic_setting('gro_error_message')) : ?><div class="form-alert error"><?php echo esc_html(gro_dynamic_setting('gro_error_message')); ?></div><?php endif; ?>
        </div>
        <form class="booking-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <input type="hidden" name="action" value="gro_dynamic_booking">
            <?php wp_nonce_field('gro_dynamic_booking', 'gro_nonce'); ?>
            <div class="honeypot" aria-hidden="true"><input name="company" tabindex="-1" autocomplete="off"></div>
            <select name="service" id="service" required>
                <option value="" selected disabled><?php echo esc_html(gro_dynamic_setting('gro_service_label')); ?></option>
                <?php foreach ($services as $service) : ?><option value="<?php echo esc_attr(get_the_title($service)); ?>"><?php echo esc_html(get_the_title($service)); ?></option><?php endforeach; ?>
            </select>
            <div class="form-row">
                <input name="full_name" placeholder="<?php echo esc_attr(gro_dynamic_setting('gro_name_label')); ?>" maxlength="100" required>
                <input name="contact" placeholder="<?php echo esc_attr(gro_dynamic_setting('gro_contact_label')); ?>" maxlength="100" required>
            </div>
            <div class="form-row">
                <input type="date" name="date" min="<?php echo esc_attr(wp_date('Y-m-d')); ?>" max="<?php echo esc_attr(wp_date('Y-m-d', strtotime('+2 years'))); ?>" required>
                <input type="time" name="time" required>
            </div>
            <textarea name="message" placeholder="<?php echo esc_attr(gro_dynamic_setting('gro_message_label')); ?>" maxlength="2000"></textarea>
            <button class="button form-submit" type="submit"><?php echo esc_html(gro_dynamic_setting('gro_submit_label')); ?></button>
            <?php if (gro_dynamic_setting('gro_form_note')) : ?><p class="form-note"><?php echo esc_html(gro_dynamic_setting('gro_form_note')); ?></p><?php endif; ?>
        </form>
    </article>
</section>
<?php get_footer(); ?>
