</main>
<?php if (!is_front_page()) : ?>
<footer class="site-footer" id="kontakt">
    <div class="footer-grid">
        <?php if (gro_dynamic_setting('gro_footer_about')) : ?>
        <section>
            <h3><?php echo esc_html(get_bloginfo('name')); ?></h3>
            <p><?php echo esc_html(gro_dynamic_setting('gro_footer_about')); ?></p>
        </section>
        <?php endif; ?>

        <section>
            <?php
            $legal_links = [
                [get_privacy_policy_url(), get_the_title((int) get_option('wp_page_for_privacy_policy'))],
                [gro_dynamic_setting('gro_terms_url'), wp_parse_url(gro_dynamic_setting('gro_terms_url'), PHP_URL_HOST)],
                [gro_dynamic_setting('gro_cookies_url'), wp_parse_url(gro_dynamic_setting('gro_cookies_url'), PHP_URL_HOST)],
            ];
            foreach ($legal_links as $legal_link) :
                if ($legal_link[0] && $legal_link[1]) : ?>
                    <a href="<?php echo esc_url($legal_link[0]); ?>"><?php echo esc_html($legal_link[1]); ?></a>
                <?php endif;
            endforeach; ?>
        </section>

        <section>
            <?php wp_nav_menu(['theme_location' => 'footer', 'container' => false, 'fallback_cb' => false, 'depth' => 1]); ?>
        </section>

        <section>
            <?php if (gro_dynamic_setting('gro_address')) : ?><p><?php echo esc_html(gro_dynamic_setting('gro_address')); ?></p><?php endif; ?>
            <?php if (gro_dynamic_setting('gro_phone')) : ?><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', gro_dynamic_setting('gro_phone'))); ?>"><?php echo esc_html(gro_dynamic_setting('gro_phone')); ?></a><?php endif; ?>
            <?php if (is_email(gro_dynamic_setting('gro_email'))) : ?><a href="mailto:<?php echo esc_attr(gro_dynamic_setting('gro_email')); ?>"><?php echo esc_html(antispambot(gro_dynamic_setting('gro_email'))); ?></a><?php endif; ?>
            <?php if (gro_dynamic_setting('gro_map_url')) : ?><a class="map-placeholder" href="<?php echo esc_url(gro_dynamic_setting('gro_map_url')); ?>" target="_blank" rel="noopener"><span><?php echo esc_html(wp_parse_url(gro_dynamic_setting('gro_map_url'), PHP_URL_HOST)); ?></span></a><?php endif; ?>
        </section>
    </div>
    <div class="footer-bottom">
        <span>© <?php echo esc_html(wp_date('Y')); ?> <?php echo esc_html(get_bloginfo('name')); ?></span>
        <div class="footer-badges">
            <?php foreach (['gro_facebook_url' => 'Facebook', 'gro_x_url' => 'X', 'gro_instagram_url' => 'Instagram'] as $key => $label) : ?>
                <?php if (gro_dynamic_setting($key)) : ?><a href="<?php echo esc_url(gro_dynamic_setting($key)); ?>" target="_blank" rel="noopener"><?php echo esc_html($label); ?></a><?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</footer>
<?php endif; ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
