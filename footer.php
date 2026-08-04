</main>
<footer class="site-footer" id="kontakt">
    <div class="footer-grid">
        <section>
            <h3><?php esc_html_e('O nas', 'gun-resort-one'); ?></h3>
            <p><?php echo esc_html(get_theme_mod('gro_footer_about', 'Profesjonalne tory strzeleckie, doświadczeni instruktorzy i oferta dla gości indywidualnych oraz firm.')); ?></p>
        </section>
        <section>
            <h3><?php esc_html_e('Legal', 'gun-resort-one'); ?></h3>
            <?php
            $legal_links = [
                [get_privacy_policy_url(), __('Polityka prywatności', 'gun-resort-one')],
                [get_theme_mod('gro_terms_url', ''), __('Regulamin', 'gun-resort-one')],
                [get_theme_mod('gro_cookies_url', ''), __('Pliki cookies', 'gun-resort-one')],
            ];
            foreach ($legal_links as $legal_link) :
                if ($legal_link[0]) : ?>
                    <a href="<?php echo esc_url($legal_link[0]); ?>"><?php echo esc_html($legal_link[1]); ?></a>
                <?php else : ?>
                    <span class="footer-disabled-link"><?php echo esc_html($legal_link[1]); ?></span>
                <?php endif;
            endforeach; ?>
        </section>
        <section>
            <h3><?php esc_html_e('Szybkie linki', 'gun-resort-one'); ?></h3>
            <a href="<?php echo esc_url(gro_section_url('oferta')); ?>"><?php esc_html_e('Oferta', 'gun-resort-one'); ?></a>
            <a href="<?php echo esc_url(gro_section_url('cennik')); ?>"><?php esc_html_e('Cennik', 'gun-resort-one'); ?></a>
            <a href="<?php echo esc_url(gro_section_url('rezerwacja')); ?>"><?php esc_html_e('Rezerwacja', 'gun-resort-one'); ?></a>
        </section>
        <section>
            <h3><?php esc_html_e('Kontakt', 'gun-resort-one'); ?></h3>
            <p><span aria-hidden="true">⌖</span> <?php echo esc_html(get_theme_mod('gro_address', 'ul. Przykładowa 69, 87-100 Toruń')); ?></p>
            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', get_theme_mod('gro_phone', '690 629 112'))); ?>"><span aria-hidden="true">☎</span> <?php echo esc_html(get_theme_mod('gro_phone', '690 629 112')); ?></a>
            <?php $contact_email = sanitize_email(get_theme_mod('gro_contact_email', get_option('admin_email'))); ?>
            <?php if (is_email($contact_email)) : ?><a href="mailto:<?php echo esc_attr($contact_email); ?>"><?php echo esc_html(antispambot($contact_email)); ?></a><?php endif; ?>
            <?php $map_url = get_theme_mod('gro_map_url', ''); ?>
            <?php if ($map_url) : ?><a class="map-placeholder" href="<?php echo esc_url($map_url); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e('Otwórz lokalizację na mapie', 'gun-resort-one'); ?>"><span><?php esc_html_e('MAPA', 'gun-resort-one'); ?></span><i aria-hidden="true">+</i></a>
            <?php else : ?><div class="map-placeholder" aria-label="<?php esc_attr_e('Miejsce na odnośnik do mapy', 'gun-resort-one'); ?>"><span><?php esc_html_e('MAPA', 'gun-resort-one'); ?></span><i aria-hidden="true">+</i></div><?php endif; ?>
        </section>
    </div>
    <div class="footer-bottom">
        <span>© <?php echo esc_html(wp_date('Y')); ?> <?php echo esc_html(get_bloginfo('name')); ?></span>
        <div class="footer-badges" aria-label="<?php esc_attr_e('Płatności i media społecznościowe', 'gun-resort-one'); ?>">
            <b aria-label="Visa">VISA</b><b aria-label="Mastercard">MC</b>
            <?php $facebook = get_theme_mod('gro_facebook_url', ''); ?>
            <?php $instagram = get_theme_mod('gro_instagram_url', ''); ?>
            <?php if ($facebook) : ?><a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener" aria-label="Facebook">f</a><?php else : ?><span aria-hidden="true">f</span><?php endif; ?>
            <span aria-hidden="true">𝕏</span>
            <?php if ($instagram) : ?><a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener" aria-label="Instagram">◎</a><?php else : ?><span aria-hidden="true">◎</span><?php endif; ?>
        </div>
    </div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
