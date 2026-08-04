<?php
if (!defined('ABSPATH')) { exit; }

function gro_dynamic_setting($key) {
    return trim((string) get_theme_mod($key, ''));
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

function gro_dynamic_customize($customizer) {
    $customizer->add_section('gro_dynamic_content', [
        'title' => 'Treść strony i komunikaty',
        'priority' => 20,
    ]);

    $fields = [
        'gro_hero_title' => ['Nagłówek główny', 'textarea'],
        'gro_hero_text' => ['Opis główny', 'textarea'],
        'gro_offer_label' => ['Przycisk oferty', 'text'],
        'gro_booking_label' => ['Przycisk rezerwacji', 'text'],
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
        $customizer->add_setting($id, ['default' => '', 'sanitize_callback' => $sanitize]);
        $customizer->add_control($id, ['label' => $field[0], 'section' => 'gro_dynamic_content', 'type' => $field[1]]);
    }

    $customizer->add_setting('gro_hero_image', ['default' => 0, 'sanitize_callback' => 'absint']);
    $customizer->add_control(new WP_Customize_Media_Control($customizer, 'gro_hero_image', [
        'label' => 'Zdjęcie główne',
        'section' => 'gro_dynamic_content',
        'mime_type' => 'image',
    ]));
}
add_action('customize_register', 'gro_dynamic_customize', 5);

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
