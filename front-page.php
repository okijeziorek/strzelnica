<?php
get_header();
$booking_status = isset($_GET['booking']) ? sanitize_key(wp_unslash($_GET['booking'])) : '';
$hero_image     = gro_image_url('gro_hero_image', 'hero.jpg');
$restaurant_meta = array_filter(array_map('trim', explode('|', (string) get_theme_mod('gro_restaurant_meta', 'Dania z grilla|Menu i wino'))));
$hotel_meta      = array_filter(array_map('trim', explode('|', (string) get_theme_mod('gro_hotel_meta', '4 pokoje standard|2 apartamenty komfort'))));
?>
<section class="hero-panel" id="oferta" style="<?php echo esc_attr('--hero-image:url(\'' . esc_url($hero_image) . '\');'); ?>">
    <div class="hero-content">
        <h1><?php echo nl2br(esc_html(get_theme_mod('gro_hero_title', "Poczuj emocje.\nOpanuj celność.\nGun Resort."))); ?></h1>
        <p><?php echo esc_html(get_theme_mod('gro_hero_text', 'Opanuj emocje i celność w bezpiecznych warunkach pod okiem doświadczonych instruktorów.')); ?></p>
        <div class="hero-actions">
            <a class="button" href="#pakiety"><?php esc_html_e('Zobacz ofertę', 'gun-resort-one'); ?></a>
            <a class="button js-booking-link" data-service="Strzelnica" href="#rezerwacja"><?php esc_html_e('Rezerwuj online', 'gun-resort-one'); ?></a>
        </div>
    </div>
</section>
<div class="slider-dots" aria-hidden="true"><span></span><span class="active"></span><span></span></div>

<section class="feature-grid" id="pakiety" aria-label="<?php esc_attr_e('Najważniejsze zalety', 'gun-resort-one'); ?>">
<?php
$features = [
    [
        'icon'  => '<svg viewBox="0 0 64 64" focusable="false"><path d="M32 5 53 13v17c0 14-9 24-21 29C20 54 11 44 11 30V13z"/><circle cx="32" cy="29" r="9"/><path d="m27 38-3 10 8-4 8 4-3-10"/></svg>',
        'title' => __('Opieka instruktorów', 'gun-resort-one'),
        'text'  => __('Doświadczeni instruktorzy zadbają o Twoje bezpieczeństwo.', 'gun-resort-one'),
    ],
    [
        'icon'  => '<svg viewBox="0 0 64 64" focusable="false"><circle cx="29" cy="34" r="22"/><circle cx="29" cy="34" r="14"/><circle cx="29" cy="34" r="5"/><path d="m33 30 21-21m-9 1h9v9"/></svg>',
        'title' => __('Nowoczesne tory', 'gun-resort-one'),
        'text'  => __('Pełne wyposażenie i indywidualne stanowiska.', 'gun-resort-one'),
    ],
    [
        'icon'  => '<svg viewBox="0 0 64 64" focusable="false"><path d="M8 19h36l11 8-8 9H27l-8-6H8z"/><path d="M29 36h14l-3 20H27zM15 19v-5h28v5M48 23h8"/><circle cx="18" cy="27" r="2"/></svg>',
        'title' => __('Szeroki arsenał', 'gun-resort-one'),
        'text'  => __('Broń krótka i długa — od klasyki po nowoczesność.', 'gun-resort-one'),
    ],
    [
        'icon'  => '<svg viewBox="0 0 64 64" focusable="false"><path d="M20 8h24v14c0 10-5 18-12 18s-12-8-12-18z"/><path d="M20 13H9v7c0 8 5 13 13 13m22-20h11v7c0 8-5 13-13 13M32 40v10m-11 6h22M25 50h14"/></svg>',
        'title' => __('Vouchery i imprezy', 'gun-resort-one'),
        'text'  => __('Wieczory kawalerskie, eventy i prezenty.', 'gun-resort-one'),
    ],
];
foreach ($features as $feature) : ?>
    <article class="feature-card">
        <div class="line-icon" aria-hidden="true"><?php echo $feature['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
        <h2><?php echo esc_html($feature['title']); ?></h2>
        <p><?php echo esc_html($feature['text']); ?></p>
    </article>
<?php endforeach; ?>
</section>

<section class="experience-panel" id="dla-kogo">
    <article class="experience-card">
        <img src="<?php echo esc_url(gro_image_url('gro_restaurant_image', 'restaurant.jpg')); ?>" alt="<?php esc_attr_e('Wnętrze restauracji', 'gun-resort-one'); ?>" loading="lazy" width="1000" height="360">
        <div class="experience-body">
            <h2><?php echo esc_html(get_theme_mod('gro_restaurant_title', 'Restauracja Na Celowniku')); ?></h2>
            <div class="meta-row">
                <?php foreach (array_slice($restaurant_meta, 0, 2) as $meta) : ?><span><i aria-hidden="true">♨</i> <?php echo esc_html($meta); ?></span><?php endforeach; ?>
            </div>
            <p><?php echo esc_html(get_theme_mod('gro_restaurant_text', 'Wyjątkowa kuchnia, starannie dobrane wina i atmosfera sprzyjająca odpoczynkowi po udanej sesji na strzelnicy.')); ?></p>
            <div class="card-actions">
                <a class="button js-booking-link" data-service="Restauracja" href="#rezerwacja"><?php esc_html_e('Zarezerwuj stolik', 'gun-resort-one'); ?></a>
                <?php $menu_url = get_theme_mod('gro_menu_url', ''); ?>
                <a class="button<?php echo $menu_url ? '' : ' js-booking-link'; ?>" <?php echo $menu_url ? 'target="_blank" rel="noopener"' : 'data-service="Restauracja"'; ?> href="<?php echo esc_url($menu_url ? $menu_url : '#rezerwacja'); ?>"><?php esc_html_e('Zobacz menu', 'gun-resort-one'); ?></a>
            </div>
        </div>
    </article>
    <article class="experience-card">
        <img src="<?php echo esc_url(gro_image_url('gro_hotel_image', 'hotel.jpg')); ?>" alt="<?php esc_attr_e('Elegancki pokój hotelowy', 'gun-resort-one'); ?>" loading="lazy" width="1000" height="360">
        <div class="experience-body">
            <h2><?php echo esc_html(get_theme_mod('gro_hotel_title', 'Pokoje Hotelowe „Gun Resort”')); ?></h2>
            <div class="meta-row">
                <?php foreach (array_slice($hotel_meta, 0, 2) as $meta) : ?><span><i aria-hidden="true">▱</i> <?php echo esc_html($meta); ?></span><?php endforeach; ?>
            </div>
            <p><?php echo esc_html(get_theme_mod('gro_hotel_text', 'Komfortowe i nowoczesne pokoje dla naszych gości. Idealne miejsce na odpoczynek po aktywnym dniu.')); ?></p>
            <div class="card-actions">
                <a class="button js-booking-link" data-service="Hotel" href="#rezerwacja"><?php esc_html_e('Zarezerwuj pokój', 'gun-resort-one'); ?></a>
                <?php $hotel_url = get_theme_mod('gro_hotel_url', ''); ?>
                <a class="button<?php echo $hotel_url ? '' : ' js-booking-link'; ?>" <?php echo $hotel_url ? 'target="_blank" rel="noopener"' : 'data-service="Hotel"'; ?> href="<?php echo esc_url($hotel_url ? $hotel_url : '#rezerwacja'); ?>"><?php esc_html_e('Sprawdź dostępność', 'gun-resort-one'); ?></a>
            </div>
        </div>
    </article>
</section>

<section class="booking-grid">
    <article class="price-card" id="cennik">
        <h2><?php esc_html_e('Cennik', 'gun-resort-one'); ?></h2>
        <dl>
            <?php foreach (gro_price_rows() as $row) : ?>
                <div><dt><?php echo esc_html($row['label']); ?></dt><dd><?php echo esc_html($row['price']); ?></dd></div>
            <?php endforeach; ?>
        </dl>
    </article>

    <article class="form-card" id="rezerwacja">
        <h2><?php esc_html_e('Formularz', 'gun-resort-one'); ?></h2>
        <div class="form-feedback" aria-live="polite">
            <?php if ('ok' === $booking_status) : ?>
                <div class="form-alert success" role="status"><?php esc_html_e('Wiadomość została wysłana.', 'gun-resort-one'); ?></div>
            <?php elseif ('error' === $booking_status) : ?>
                <div class="form-alert error" role="alert"><?php esc_html_e('Nie udało się wysłać wiadomości. Sprawdź pola i spróbuj ponownie.', 'gun-resort-one'); ?></div>
            <?php endif; ?>
        </div>
        <form class="booking-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <input type="hidden" name="action" value="gro_booking">
            <?php wp_nonce_field('gro_booking', 'gro_nonce'); ?>

            <div class="honeypot" aria-hidden="true">
                <label for="booking-company">Firma</label>
                <input id="booking-company" name="company" tabindex="-1" autocomplete="off">
            </div>

            <label class="sr-only" for="service"><?php esc_html_e('Usługa', 'gun-resort-one'); ?></label>
            <select name="service" id="service" required>
                <option value="" selected disabled><?php esc_html_e('Wybierz usługę', 'gun-resort-one'); ?></option>
                <option value="Strzelnica"><?php esc_html_e('Strzelnica', 'gun-resort-one'); ?></option>
                <option value="Restauracja"><?php esc_html_e('Restauracja', 'gun-resort-one'); ?></option>
                <option value="Hotel"><?php esc_html_e('Hotel', 'gun-resort-one'); ?></option>
                <option value="Event firmowy"><?php esc_html_e('Event firmowy', 'gun-resort-one'); ?></option>
            </select>

            <div class="form-row">
                <label class="sr-only" for="booking-name"><?php esc_html_e('Imię i nazwisko', 'gun-resort-one'); ?></label>
                <input id="booking-name" name="full_name" placeholder="<?php esc_attr_e('Imię i nazwisko', 'gun-resort-one'); ?>" autocomplete="name" maxlength="100" required>
                <label class="sr-only" for="booking-contact"><?php esc_html_e('Telefon lub e-mail', 'gun-resort-one'); ?></label>
                <input id="booking-contact" name="contact" placeholder="<?php esc_attr_e('Telefon lub e-mail', 'gun-resort-one'); ?>" autocomplete="email" maxlength="100" required>
            </div>
            <div class="form-row">
                <label class="sr-only" for="booking-date"><?php esc_html_e('Data', 'gun-resort-one'); ?></label>
                <input id="booking-date" type="date" name="date" min="<?php echo esc_attr(wp_date('Y-m-d')); ?>" max="<?php echo esc_attr(wp_date('Y-m-d', strtotime('+2 years'))); ?>" required>
                <label class="sr-only" for="booking-time"><?php esc_html_e('Godzina', 'gun-resort-one'); ?></label>
                <input id="booking-time" type="time" name="time" required>
            </div>
            <label class="sr-only" for="booking-message"><?php esc_html_e('Wiadomość', 'gun-resort-one'); ?></label>
            <textarea id="booking-message" name="message" placeholder="<?php esc_attr_e('Wiadomość', 'gun-resort-one'); ?>" maxlength="2000"></textarea>
            <button class="button form-submit" type="submit"><?php esc_html_e('Rezerwuj', 'gun-resort-one'); ?></button>
            <p class="form-note"><?php esc_html_e('Po wysłaniu zapytania obsługa skontaktuje się w celu potwierdzenia terminu.', 'gun-resort-one'); ?></p>
        </form>
    </article>
</section>
<?php get_footer(); ?>
