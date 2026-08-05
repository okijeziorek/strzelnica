<?php
if (!defined('ABSPATH')) { exit; }

function gro_dynamic_defaults() {
    return [
        'gro_hero_title' => "Poczuj emocje.\nOpanuj celność.\nGun Resort.",
        'gro_hero_text' => 'Opanuj emocje i celność w bezpiecznych warunkach pod okiem doświadczonych instruktorów.',
        'gro_offer_label' => 'Zobacz ofertę',
        'gro_offer_url' => '#pakiety',
        'gro_booking_label' => 'Rezerwuj online',
        'gro_booking_url' => '#rezerwacja',
        'gro_features_label' => 'Dlaczego Gun Resort',
        'gro_phone' => '690 629 112',
        'gro_hours' => 'Pn–Pt 10:00–22:00',
        'gro_top_note' => 'Najlepsi instruktorzy i bezpieczne tory',
        'gro_open_menu_label' => 'Otwórz menu',
        'gro_close_menu_label' => 'Zamknij menu',
    ];
}

function gro_dynamic_setting($key) {
    $defaults = gro_dynamic_defaults();
    return trim((string) get_theme_mod($key, $defaults[$key] ?? ''));
}

function gro_dynamic_sanitize_link($value) {
    $value = trim((string) $value);
    if (0 === strpos($value, '#')) {
        return '#' . sanitize_title(substr($value, 1));
    }
    return esc_url_raw($value);
}

function gro_dynamic_items($type) {
    return get_posts([
        'post_type' => $type,
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => ['menu_order' => 'ASC', 'date' => 'ASC'],
    ]);
}

function gro_dynamic_register_types() {
    $types = [
        'gro_feature' => ['Zalety', 'Zaleta', ['title', 'editor', 'thumbnail', 'page-attributes']],
        'gro_card' => ['Karty oferty', 'Karta oferty', ['title', 'editor', 'excerpt', 'thumbnail', 'page-attributes']],
        'gro_service' => ['Usługi', 'Usługa', ['title', 'editor', 'page-attributes']],
        'gro_price' => ['Cennik', 'Pozycja cennika', ['title', 'excerpt', 'page-attributes']],
    ];

    foreach ($types as $slug => $data) {
        register_post_type($slug, [
            'labels' => [
                'name' => $data[0],
                'singular_name' => $data[1],
                'add_new_item' => 'Dodaj: ' . $data[1],
                'edit_item' => 'Edytuj: ' . $data[1],
            ],
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'supports' => $data[2],
            'menu_icon' => 'dashicons-edit-page',
        ]);
    }
}
add_action('init', 'gro_dynamic_register_types');

function gro_dynamic_seed_starter_content() {
    gro_dynamic_register_types();

    $existing = get_posts([
        'post_type' => 'gro_feature',
        'post_status' => 'any',
        'numberposts' => 1,
        'fields' => 'ids',
    ]);

    if ($existing) {
        return;
    }

    $features = [
        ['Opieka instruktorów', 'Doświadczeni instruktorzy zadbają o Twoje bezpieczeństwo.'],
        ['Nowoczesne tory', 'Pełne wyposażenie i indywidualne stanowiska.'],
        ['Szeroki arsenał', 'Broń krótka i długa — od klasyki po nowoczesność.'],
        ['Vouchery i imprezy', 'Wieczory kawalerskie, eventy i prezenty.'],
    ];

    foreach ($features as $order => $feature) {
        wp_insert_post([
            'post_type' => 'gro_feature',
            'post_status' => 'publish',
            'post_title' => $feature[0],
            'post_content' => $feature[1],
            'menu_order' => $order,
        ]);
    }
}
add_action('after_switch_theme', 'gro_dynamic_seed_starter_content');

function gro_dynamic_feature_icon($index) {
    $icons = [
        '<svg viewBox="0 0 64 64" aria-hidden="true"><path d="M32 5 53 13v17c0 14-9 24-21 29C20 54 11 44 11 30V13z"/><circle cx="32" cy="29" r="9"/><path d="m27 38-3 10 8-4 8 4-3-10"/></svg>',
        '<svg viewBox="0 0 64 64" aria-hidden="true"><circle cx="29" cy="34" r="22"/><circle cx="29" cy="34" r="14"/><circle cx="29" cy="34" r="5"/><path d="m33 30 21-21m-9 1h9v9"/></svg>',
        '<img class="feature-glock-icon" src="' . esc_url(get_template_directory_uri() . '/assets/icon-glock-orange.png') . '" alt="">',
        '<svg viewBox="0 0 64 64" aria-hidden="true"><path d="M20 8h24v14c0 10-5 18-12 18s-12-8-12-18z"/><path d="M20 13H9v7c0 8 5 13 13 13m22-20h11v7c0 8-5 13-13 13M32 40v10m-11 6h22M25 50h14"/></svg>',
    ];

    return $icons[$index % count($icons)];
}

function gro_dynamic_customize($customizer) {
    $customizer->add_section('gro_dynamic_content', [
        'title' => 'Strona główna — treść',
        'description' => 'Edytuj górny pasek, sekcję główną, przyciski i elementy nawigacji. Cztery kafelki edytujesz osobno w panelu Zalety.',
        'priority' => 20,
    ]);

    $fields = [
        'gro_hero_title' => ['Nagłówek główny', 'textarea'],
        'gro_hero_text' => ['Opis główny', 'textarea'],
        'gro_offer_label' => ['Przycisk oferty', 'text'],
        'gro_offer_url' => ['Odnośnik przycisku oferty (adres lub #sekcja)', 'text'],
        'gro_booking_label' => ['Przycisk rezerwacji', 'text'],
        'gro_booking_url' => ['Odnośnik przycisku rezerwacji (adres lub #sekcja)', 'text'],
        'gro_features_label' => ['Etykieta sekcji zalet', 'text'],
        'gro_prices_label' => ['Nagłówek cennika', 'text'],
        'gro_form_label' => ['Nagłówek formularza', 'text'],
        'gro_service_label' => ['Pole wyboru usługi', 'text'],
        'gro_name_label' => ['Pole imienia i nazwiska', 'text'],
        'gro_contact_label' => ['Pole telefonu lub e-maila', 'text'],
        'gro_message_label' => ['Pole wiadomości', 'text'],
        'gro_submit_label' => ['Przycisk wysłania', 'text'],
        'gro_form_note' => ['Notatka formularza', 'textarea'],
        'gro_success_message' => ['Komunikat sukcesu', 'text'],
        'gro_error_message' => ['Komunikat błędu', 'text'],
        'gro_open_menu_label' => ['Otwórz menu', 'text'],
        'gro_close_menu_label' => ['Zamknij menu', 'text'],
        'gro_sending_label' => ['Wysyłanie formularza', 'text'],
        'gro_phone' => ['Telefon', 'text'],
        'gro_email' => ['E-mail kontaktowy', 'email'],
        'gro_booking_email' => ['E-mail odbiorcy rezerwacji', 'email'],
        'gro_address' => ['Adres', 'text'],
        'gro_hours' => ['Godziny otwarcia', 'text'],
        'gro_top_note' => ['Tekst górnego paska', 'text'],
        'gro_footer_about' => ['Opis w stopce', 'textarea'],
        'gro_map_url' => ['Mapa', 'url'],
        'gro_terms_url' => ['Regulamin', 'url'],
        'gro_cookies_url' => ['Cookies', 'url'],
        'gro_facebook_url' => ['Facebook', 'url'],
        'gro_x_url' => ['X', 'url'],
        'gro_instagram_url' => ['Instagram', 'url'],
    ];

    foreach ($fields as $id => $field) {
        $sanitize = 'sanitize_text_field';
        if ('textarea' === $field[1]) { $sanitize = 'sanitize_textarea_field'; }
        if ('email' === $field[1]) { $sanitize = 'sanitize_email'; }
        if ('url' === $field[1]) { $sanitize = 'esc_url_raw'; }
        if (in_array($id, ['gro_offer_url', 'gro_booking_url'], true)) { $sanitize = 'gro_dynamic_sanitize_link'; }
        $defaults = gro_dynamic_defaults();
        $customizer->add_setting($id, ['default' => $defaults[$id] ?? '', 'sanitize_callback' => $sanitize]);
        $customizer->add_control($id, ['label' => $field[0], 'section' => 'gro_dynamic_content', 'type' => $field[1]]);
    }

    foreach ([
        'gro_show_primary_navigation' => ['Pokaż menu główne', false],
        'gro_show_booking_cta' => ['Pokaż przycisk rezerwacji', false],
    ] as $id => $control) {
        $customizer->add_setting($id, [
            'default' => $control[1],
            'sanitize_callback' => static function ($value) { return (bool) $value; },
        ]);
        $customizer->add_control($id, [
            'label' => $control[0],
            'section' => 'gro_dynamic_content',
            'type' => 'checkbox',
        ]);
    }

    $customizer->add_setting('gro_hero_image', ['default' => 0, 'sanitize_callback' => 'absint']);
    $customizer->add_control(new WP_Customize_Media_Control($customizer, 'gro_hero_image', [
        'label' => 'Zdjęcie główne',
        'section' => 'gro_dynamic_content',
        'mime_type' => 'image',
    ]));
}
add_action('customize_register', 'gro_dynamic_customize', 5);

function gro_dynamic_admin_notice() {
    $screen = get_current_screen();
    if (!$screen || 'dashboard' !== $screen->base || !current_user_can('edit_theme_options')) {
        return;
    }
    $customize_url = admin_url('customize.php');
    ?>
    <div class="notice notice-info is-dismissible">
        <p><strong><?php esc_html_e('Edycja strony Gun Resort', 'gun-resort-one'); ?></strong> — <?php esc_html_e('nagłówek, zdjęcie główne, przyciski i dane w górnym pasku zmienisz w Personalizatorze. Cztery kafelki zmienisz w sekcji „Zalety”.', 'gun-resort-one'); ?> <a href="<?php echo esc_url($customize_url); ?>"><?php esc_html_e('Edytuj stronę główną', 'gun-resort-one'); ?></a></p>
    </div>
    <?php
}
add_action('admin_notices', 'gro_dynamic_admin_notice');

function gro_dynamic_assets() {
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('gro-dynamic-style', get_template_directory_uri() . '/main.css', [], $version);
    wp_enqueue_script('gro-dynamic-script', get_template_directory_uri() . '/theme.js', [], $version, true);
    wp_localize_script('gro-dynamic-script', 'groTheme', [
        'openMenu' => gro_dynamic_setting('gro_open_menu_label'),
        'closeMenu' => gro_dynamic_setting('gro_close_menu_label'),
        'sending' => gro_dynamic_setting('gro_sending_label'),
    ]);
}
add_action('wp_enqueue_scripts', 'gro_dynamic_assets', 50);

function gro_dynamic_services() {
    return array_values(array_filter(array_map(static function ($post) {
        return get_the_title($post);
    }, gro_dynamic_items('gro_service'))));
}

function gro_dynamic_redirect($status) {
    return add_query_arg('booking', sanitize_key($status), home_url('/')) . '#rezerwacja';
}

function gro_dynamic_booking() {
    if ('POST' !== strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? ''))) {
        wp_safe_redirect(gro_dynamic_redirect('error'), 303);
        exit;
    }

    if (!isset($_POST['gro_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['gro_nonce'])), 'gro_dynamic_booking')) {
        wp_die(esc_html__('Nieprawidłowe żądanie.', 'gun-resort-one'), '', ['response' => 403]);
    }

    if ('' !== sanitize_text_field(wp_unslash($_POST['company'] ?? ''))) {
        wp_safe_redirect(gro_dynamic_redirect('ok'), 303);
        exit;
    }

    $name = sanitize_text_field(wp_unslash($_POST['full_name'] ?? ''));
    $contact = sanitize_text_field(wp_unslash($_POST['contact'] ?? ''));
    $service = sanitize_text_field(wp_unslash($_POST['service'] ?? ''));
    $date = sanitize_text_field(wp_unslash($_POST['date'] ?? ''));
    $time = sanitize_text_field(wp_unslash($_POST['time'] ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));

    $date_object = DateTimeImmutable::createFromFormat('!Y-m-d', $date, wp_timezone());
    $today = new DateTimeImmutable('today', wp_timezone());
    $valid_contact = is_email($contact) || 1 === preg_match('/^\+?[0-9][0-9\s().-]{6,24}$/', $contact);
    $valid_date = $date_object && $date_object->format('Y-m-d') === $date && $date_object >= $today && $date_object <= $today->modify('+2 years');

    if (mb_strlen($name) < 2 || !$valid_contact || !in_array($service, gro_dynamic_services(), true) || !$valid_date || 1 !== preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $time) || mb_strlen($message) > 2000) {
        wp_safe_redirect(gro_dynamic_redirect('error'), 303);
        exit;
    }

    $recipient = sanitize_email(gro_dynamic_setting('gro_booking_email'));
    $subject = implode(' — ', array_filter([get_bloginfo('name'), $service, $name]));
    $body = implode("\n", ['Usługa: ' . $service, 'Imię i nazwisko: ' . $name, 'Kontakt: ' . $contact, 'Data: ' . $date, 'Godzina: ' . $time, '', $message]);
    $sent = is_email($recipient) && wp_mail($recipient, $subject, $body, ['Content-Type: text/plain; charset=UTF-8']);

    wp_safe_redirect(gro_dynamic_redirect($sent ? 'ok' : 'error'), 303);
    exit;
}
add_action('admin_post_nopriv_gro_dynamic_booking', 'gro_dynamic_booking');
add_action('admin_post_gro_dynamic_booking', 'gro_dynamic_booking');
