<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Konfiguracja motywu.
 */
function gro_setup() {
    load_theme_textdomain('gun-resort-one', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('custom-logo', [
        'height'      => 72,
        'width'       => 220,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    register_nav_menus([
        'primary' => __('Menu główne', 'gun-resort-one'),
        'footer'  => __('Menu w stopce', 'gun-resort-one'),
    ]);
}
add_action('after_setup_theme', 'gro_setup');

/**
 * Style i skrypty.
 */
function gro_assets() {
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style('gro-theme-meta', get_stylesheet_uri(), [], $theme_version);
    wp_enqueue_style(
        'gro-style',
        get_template_directory_uri() . '/assets/css/main.css',
        ['gro-theme-meta'],
        $theme_version
    );
    wp_enqueue_script(
        'gro-script',
        get_template_directory_uri() . '/assets/js/theme.js',
        [],
        $theme_version,
        true
    );

    $accent = sanitize_hex_color(get_theme_mod('gro_accent', '#e65c0b'));
    if (!$accent) {
        $accent = '#e65c0b';
    }
    wp_add_inline_style('gro-style', ':root{--orange:' . $accent . ';}');
}
add_action('wp_enqueue_scripts', 'gro_assets');

/**
 * Bezpieczny adres sekcji strony głównej, również podczas wejścia z podstrony.
 */
function gro_section_url($section_id) {
    $section_id = sanitize_title($section_id);
    return trailingslashit(home_url('/')) . '#' . $section_id;
}

/**
 * Domyślne menu, gdy użytkownik nie przypisał własnego.
 */
function gro_menu_fallback() {
    $items = [
        ['Oferta', 'oferta'],
        ['Pakiety', 'pakiety'],
        ['Cennik', 'cennik'],
        ['Dla kogo', 'dla-kogo'],
        ['Rezerwuj online', 'rezerwacja'],
        ['Kontakt', 'kontakt'],
    ];

    echo '<ul class="nav-list">';
    foreach ($items as $item) {
        echo '<li><a href="' . esc_url(gro_section_url($item[1])) . '">' . esc_html($item[0]) . '</a></li>';
    }
    echo '</ul>';
}

/**
 * Zwraca adres obrazu z biblioteki mediów albo obraz domyślny motywu.
 */
function gro_image_url($setting, $fallback_filename) {
    $attachment_id = absint(get_theme_mod($setting, 0));
    if ($attachment_id) {
        $url = wp_get_attachment_image_url($attachment_id, 'full');
        if ($url) {
            return $url;
        }
    }

    return get_template_directory_uri() . '/assets/images/' . ltrim($fallback_filename, '/');
}

/**
 * Domyślny cennik.
 */
function gro_default_prices() {
    return implode("\n", [
        'Wejście na strzelnicę|100 PLN',
        'Amunicja 9 mm (50 szt.)|100 PLN',
        'Glock 17|100 PLN',
        'Pakiet karabinowy|400 PLN',
        'Pakiet premium|695 PLN',
        'Rezerwacja grupowa|595 PLN',
        'Voucher prezentowy|500 PLN',
    ]);
}

/**
 * Parsuje cennik zapisany jako: nazwa|cena, po jednej pozycji w wierszu.
 */
function gro_price_rows() {
    $raw  = (string) get_theme_mod('gro_prices', gro_default_prices());
    $rows = [];

    foreach (preg_split('/\r\n|\r|\n/', $raw) as $line) {
        $line = trim($line);
        if ('' === $line) {
            continue;
        }

        $parts = array_map('trim', explode('|', $line, 2));
        if (2 !== count($parts) || '' === $parts[0] || '' === $parts[1]) {
            continue;
        }

        $rows[] = [
            'label' => sanitize_text_field($parts[0]),
            'price' => sanitize_text_field($parts[1]),
        ];
    }

    if (!$rows) {
        return [
            ['label' => __('Oferta indywidualna', 'gun-resort-one'), 'price' => __('Zapytaj', 'gun-resort-one')],
        ];
    }

    return array_slice($rows, 0, 20);
}

/**
 * Sanitizacja koloru w Customizerze z bezpieczną wartością domyślną.
 */
function gro_sanitize_color($value) {
    $color = sanitize_hex_color($value);
    return $color ? $color : '#e65c0b';
}

/**
 * Pola edycyjne motywu.
 */
function gro_customize_register($wp_customize) {
    $wp_customize->add_section('gro_general', [
        'title'    => __('Gun Resort — dane i wygląd', 'gun-resort-one'),
        'priority' => 30,
    ]);
    $wp_customize->add_section('gro_home', [
        'title'    => __('Gun Resort — treść strony', 'gun-resort-one'),
        'priority' => 31,
    ]);
    $wp_customize->add_section('gro_links', [
        'title'    => __('Gun Resort — odnośniki', 'gun-resort-one'),
        'priority' => 32,
    ]);

    $general_fields = [
        'gro_phone'        => ['Telefon', '690 629 112', 'text', 'sanitize_text_field'],
        'gro_contact_email'=> ['E-mail kontaktowy', get_option('admin_email'), 'email', 'sanitize_email'],
        'gro_booking_email'=> ['E-mail odbiorcy rezerwacji', get_option('admin_email'), 'email', 'sanitize_email'],
        'gro_top_note'     => ['Tekst górnego paska', 'Najlepsi instruktorzy i bezpieczne tory', 'text', 'sanitize_text_field'],
        'gro_hours'        => ['Godziny otwarcia', 'Pn–Pt 10:00–22:00', 'text', 'sanitize_text_field'],
        'gro_city'         => ['Miejscowość', 'Toruń', 'text', 'sanitize_text_field'],
        'gro_address'      => ['Adres', 'ul. Przykładowa 69, 87-100 Toruń', 'text', 'sanitize_text_field'],
        'gro_accent'       => ['Kolor akcentu', '#e65c0b', 'color', 'gro_sanitize_color'],
    ];

    foreach ($general_fields as $id => $data) {
        $wp_customize->add_setting($id, [
            'default'           => $data[1],
            'sanitize_callback' => $data[3],
        ]);
        $wp_customize->add_control($id, [
            'label'   => __($data[0], 'gun-resort-one'),
            'section' => 'gro_general',
            'type'    => $data[2],
        ]);
    }

    $home_fields = [
        'gro_hero_title'       => ['Nagłówek główny', "Poczuj emocje.\nOpanuj celność.\nGun Resort.", 'textarea', 'sanitize_textarea_field'],
        'gro_hero_text'        => ['Opis pod nagłówkiem', 'Opanuj emocje i celność w bezpiecznych warunkach pod okiem doświadczonych instruktorów.', 'textarea', 'sanitize_textarea_field'],
        'gro_restaurant_title' => ['Tytuł restauracji', 'Restauracja Na Celowniku', 'text', 'sanitize_text_field'],
        'gro_restaurant_meta'  => ['Wyróżniki restauracji', 'Dania z grilla|Menu i wino', 'text', 'sanitize_text_field'],
        'gro_restaurant_text'  => ['Opis restauracji', 'Wyjątkowa kuchnia, starannie dobrane wina i atmosfera sprzyjająca odpoczynkowi po udanej sesji na strzelnicy.', 'textarea', 'sanitize_textarea_field'],
        'gro_hotel_title'      => ['Tytuł hotelu', 'Pokoje Hotelowe „Gun Resort”', 'text', 'sanitize_text_field'],
        'gro_hotel_meta'       => ['Wyróżniki hotelu', '4 pokoje standard|2 apartamenty komfort', 'text', 'sanitize_text_field'],
        'gro_hotel_text'       => ['Opis hotelu', 'Komfortowe i nowoczesne pokoje dla naszych gości. Idealne miejsce na odpoczynek po aktywnym dniu.', 'textarea', 'sanitize_textarea_field'],
        'gro_prices'           => ['Cennik: nazwa|cena, jeden wpis w wierszu', gro_default_prices(), 'textarea', 'sanitize_textarea_field'],
        'gro_footer_about'     => ['Opis „O nas” w stopce', 'Profesjonalne tory strzeleckie, doświadczeni instruktorzy i oferta dla gości indywidualnych oraz firm.', 'textarea', 'sanitize_textarea_field'],
    ];

    foreach ($home_fields as $id => $data) {
        $wp_customize->add_setting($id, [
            'default'           => $data[1],
            'sanitize_callback' => $data[3],
        ]);
        $wp_customize->add_control($id, [
            'label'   => __($data[0], 'gun-resort-one'),
            'section' => 'gro_home',
            'type'    => $data[2],
        ]);
    }

    $image_fields = [
        'gro_hero_image'       => ['Zdjęcie główne'],
        'gro_restaurant_image' => ['Zdjęcie restauracji'],
        'gro_hotel_image'      => ['Zdjęcie hotelu'],
    ];
    foreach ($image_fields as $id => $data) {
        $wp_customize->add_setting($id, [
            'default'           => 0,
            'sanitize_callback' => 'absint',
        ]);
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, $id, [
            'label'     => __($data[0], 'gun-resort-one'),
            'section'   => 'gro_home',
            'mime_type' => 'image',
        ]));
    }

    $link_fields = [
        'gro_menu_url'       => ['Odnośnik do menu restauracji', ''],
        'gro_hotel_url'      => ['Odnośnik do dostępności hotelu', ''],
        'gro_map_url'        => ['Odnośnik do mapy', ''],
        'gro_terms_url'      => ['Odnośnik do regulaminu', ''],
        'gro_cookies_url'    => ['Odnośnik do informacji o cookies', ''],
        'gro_facebook_url'   => ['Facebook', ''],
        'gro_instagram_url'  => ['Instagram', ''],
    ];
    foreach ($link_fields as $id => $data) {
        $wp_customize->add_setting($id, [
            'default'           => $data[1],
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control($id, [
            'label'       => __($data[0], 'gun-resort-one'),
            'section'     => 'gro_links',
            'type'        => 'url',
            'input_attrs' => ['placeholder' => 'https://'],
        ]);
    }
}
add_action('customize_register', 'gro_customize_register');

/**
 * Buduje adres powrotu po formularzu, bez przenoszenia danych osobowych do URL.
 */
function gro_booking_redirect_url($status) {
    $fallback = gro_section_url('rezerwacja');
    $referer  = wp_get_referer();
    $base_url = $referer ? remove_query_arg('booking', $referer) : home_url('/');
    $url      = add_query_arg('booking', sanitize_key($status), $base_url) . '#rezerwacja';

    return wp_validate_redirect($url, $fallback);
}

/**
 * Waliduje pole kontaktowe: adres e-mail albo numer telefonu.
 */
function gro_valid_contact($contact) {
    if (is_email($contact)) {
        return true;
    }

    return 1 === preg_match('/^\+?[0-9][0-9\s().-]{6,24}$/', $contact);
}

/**
 * Obsługa formularza rezerwacji.
 */
function gro_handle_booking() {
    $request_method = isset($_SERVER['REQUEST_METHOD']) ? strtoupper((string) $_SERVER['REQUEST_METHOD']) : '';
    if ('POST' !== $request_method) {
        wp_safe_redirect(gro_booking_redirect_url('error'), 303);
        exit;
    }

    if (
        !isset($_POST['gro_nonce']) ||
        !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['gro_nonce'])), 'gro_booking')
    ) {
        wp_die(esc_html__('Nieprawidłowe żądanie.', 'gun-resort-one'), '', ['response' => 403]);
    }

    $honeypot = sanitize_text_field(wp_unslash($_POST['company'] ?? ''));
    if ('' !== $honeypot) {
        wp_safe_redirect(gro_booking_redirect_url('ok'), 303);
        exit;
    }

    $full_name = sanitize_text_field(wp_unslash($_POST['full_name'] ?? ''));
    $contact   = sanitize_text_field(wp_unslash($_POST['contact'] ?? ''));
    $service   = sanitize_text_field(wp_unslash($_POST['service'] ?? ''));
    $date      = sanitize_text_field(wp_unslash($_POST['date'] ?? ''));
    $time      = sanitize_text_field(wp_unslash($_POST['time'] ?? ''));
    $message   = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));

    $allowed_services = ['Strzelnica', 'Restauracja', 'Hotel', 'Event firmowy'];
    $date_object      = DateTimeImmutable::createFromFormat('!Y-m-d', $date, wp_timezone());
    $today            = new DateTimeImmutable('today', wp_timezone());
    $max_date         = $today->modify('+2 years');
    $valid_date       = $date_object &&
                        $date_object->format('Y-m-d') === $date &&
                        $date_object >= $today &&
                        $date_object <= $max_date;
    $valid_time       = 1 === preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $time);

    if (
        strlen($full_name) < 2 ||
        strlen($full_name) > 200 ||
        !gro_valid_contact($contact) ||
        !in_array($service, $allowed_services, true) ||
        !$valid_date ||
        !$valid_time ||
        strlen($message) > 8000
    ) {
        wp_safe_redirect(gro_booking_redirect_url('error'), 303);
        exit;
    }

    $recipient = sanitize_email(get_theme_mod('gro_booking_email', get_option('admin_email')));
    if (!is_email($recipient)) {
        $recipient = sanitize_email(get_option('admin_email'));
    }
    if (!is_email($recipient)) {
        wp_safe_redirect(gro_booking_redirect_url('error'), 303);
        exit;
    }

    $subject = sprintf(
        __('Nowa rezerwacja — %s — %s', 'gun-resort-one'),
        $service,
        $full_name
    );
    $body = implode("\n", [
        'Serwis: ' . get_bloginfo('name'),
        'Usługa: ' . $service,
        'Imię i nazwisko: ' . $full_name,
        'Kontakt: ' . $contact,
        'Data: ' . $date,
        'Godzina: ' . $time,
        '',
        'Wiadomość:',
        $message,
    ]);

    $headers = ['Content-Type: text/plain; charset=UTF-8'];
    if (is_email($contact)) {
        $headers[] = 'Reply-To: ' . $full_name . ' <' . sanitize_email($contact) . '>';
    }

    $sent = wp_mail($recipient, $subject, $body, $headers);

    wp_safe_redirect(gro_booking_redirect_url($sent ? 'ok' : 'error'), 303);
    exit;
}
add_action('admin_post_nopriv_gro_booking', 'gro_handle_booking');
add_action('admin_post_gro_booking', 'gro_handle_booking');
