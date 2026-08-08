<?php
/**
 * One-time migration from the 1.x Customizer/CPT model to editable blocks.
 *
 * Legacy values are deliberately left in the database for rollback. The
 * migration creates a new front page and only switches WordPress to it after
 * every required object has been created successfully.
 *
 * @package GunResortOne
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Keeps old content queryable for migration and rollback without exposing its UI.
 */
function gro_register_legacy_post_types() {
	foreach ( array( 'gro_feature', 'gro_card', 'gro_price' ) as $post_type ) {
		register_post_type(
			$post_type,
			array(
				'public'       => false,
				'show_ui'      => false,
				'show_in_menu' => false,
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			)
		);
	}
}
add_action( 'init', 'gro_register_legacy_post_types', 5 );

/**
 * Returns the values used by a fresh install and as fallbacks during migration.
 *
 * @return array<string, mixed>
 */
function gro_legacy_defaults() {
	return array(
		'gro_hero_title'       => "Poczuj emocje.\nOpanuj celność.\nGun Resort.",
		'gro_hero_text'        => 'Opanuj emocje i celność w bezpiecznych warunkach pod okiem doświadczonych instruktorów.',
		'gro_offer_label'      => 'Zobacz pakiety',
		'gro_offer_url'        => '#pakiety',
		'gro_booking_label'    => 'Rezerwuj',
		'gro_booking_url'      => '#kontakt',
		'gro_features_label'   => 'Dlaczego Gun Resort?',
		'gro_phone'            => 'Telefon do uzupełnienia',
		'gro_hours'            => 'Godziny do uzupełnienia',
		'gro_top_note'         => 'Dane robocze — do uzupełnienia',
		'gro_hero_image'       => 0,
		'gro_show_booking_cta' => true,
	);
}

/**
 * Reads one legacy theme modification.
 *
 * @param string $key Theme modification key.
 * @return mixed
 */
function gro_legacy_mod( $key ) {
	$defaults = gro_legacy_defaults();
	$value    = get_theme_mod( $key, $defaults[ $key ] ?? '' );

	return is_string( $value ) ? trim( $value ) : $value;
}

/**
 * Creates a normal, paired block from already escaped inner markup.
 *
 * @param string               $name  Block name without the core/ prefix.
 * @param array<string, mixed> $attrs Block attributes.
 * @param string               $html  Saved block markup.
 * @return string
 */
function gro_block( $name, $attrs, $html ) {
	$attributes = empty( $attrs ) ? '' : ' ' . wp_json_encode( $attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

	return "<!-- wp:{$name}{$attributes} -->\n{$html}\n<!-- /wp:{$name} -->\n";
}

/**
 * Creates a self-closing block comment.
 *
 * @param string               $name  Block name without the core/ prefix.
 * @param array<string, mixed> $attrs Block attributes.
 * @return string
 */
function gro_void_block( $name, $attrs = array() ) {
	$attributes = empty( $attrs ) ? '' : ' ' . wp_json_encode( $attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

	return "<!-- wp:{$name}{$attributes} /-->\n";
}

/**
 * Builds a paragraph block.
 *
 * @param string               $text  Text or safe inline HTML.
 * @param array<string, mixed> $attrs Block attributes.
 * @return string
 */
function gro_paragraph_block( $text, $attrs = array() ) {
	$class = empty( $attrs['className'] ) ? '' : ' ' . sanitize_html_class( $attrs['className'] );

	return gro_block( 'paragraph', $attrs, '<p class="' . trim( 'wp-block-paragraph' . $class ) . '">' . wp_kses_post( $text ) . '</p>' );
}

/**
 * Builds a heading block.
 *
 * @param string               $text  Heading text or safe line breaks.
 * @param int                  $level Heading level.
 * @param array<string, mixed> $attrs Additional attributes.
 * @return string
 */
function gro_heading_block( $text, $level, $attrs = array() ) {
	if ( 2 !== $level ) {
		$attrs['level'] = $level;
	}

	$class = empty( $attrs['className'] ) ? '' : ' ' . sanitize_html_class( $attrs['className'] );
	$tag   = 'h' . absint( $level );

	return gro_block( 'heading', $attrs, '<' . $tag . ' class="' . trim( 'wp-block-heading' . $class ) . '">' . wp_kses_post( $text ) . '</' . $tag . '>' );
}

/**
 * Builds an editable button block when both label and URL are present.
 *
 * @param string $label Button label.
 * @param string $url   Button URL.
 * @param string $class_name Optional block class.
 * @return string
 */
function gro_button_block( $label, $url, $class_name = '' ) {
	if ( '' === trim( $label ) || '' === trim( $url ) ) {
		return '';
	}

	$attrs       = array();
	$block_class = 'wp-block-button';
	if ( '' !== $class_name ) {
		$attrs['className'] = $class_name;
		$block_class       .= ' ' . sanitize_html_class( $class_name );
	}

	$html = '<div class="' . esc_attr( $block_class ) . '"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></div>';

	return gro_block( 'button', $attrs, $html );
}

/**
 * Builds an editable image block.
 *
 * @param string $url       Image URL.
 * @param int    $id        Attachment ID, when available.
 * @param string $alt       Alternative text.
 * @param string $class_name Block class.
 * @return string
 */
function gro_image_block( $url, $id = 0, $alt = '', $class_name = '' ) {
	if ( '' === $url ) {
		return '';
	}

	$attrs = array(
		'sizeSlug'        => 'full',
		'linkDestination' => 'none',
	);
	if ( $id ) {
		$attrs['id'] = absint( $id );
	}
	if ( '' !== $class_name ) {
		$attrs['className'] = $class_name;
	}

	$figure_classes = array( 'wp-block-image', 'size-full' );
	if ( '' !== $class_name ) {
		$figure_classes[] = sanitize_html_class( $class_name );
	}
	$image_class = $id ? ' class="wp-image-' . absint( $id ) . '"' : '';
	$html        = '<figure class="' . esc_attr( implode( ' ', $figure_classes ) ) . '"><img src="' . esc_url( $url ) . '" alt="' . esc_attr( $alt ) . '"' . $image_class . '/></figure>';

	return gro_block( 'image', $attrs, $html );
}

/**
 * Collects legacy features, or starter content on a fresh installation.
 *
 * @return array<int, array<string, mixed>>
 */
function gro_collect_legacy_features() {
	$posts = get_posts(
		array(
			'post_type'      => 'gro_feature',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'ASC',
			),
		)
	);

	$features = array();
	foreach ( $posts as $post ) {
		$thumbnail_id = get_post_thumbnail_id( $post );
		$features[]   = array(
			'title'     => get_the_title( $post ),
			'text'      => wp_strip_all_tags( $post->post_content ),
			'image_id'  => $thumbnail_id,
			'image_url' => $thumbnail_id ? (string) wp_get_attachment_image_url( $thumbnail_id, 'full' ) : '',
			'image_alt' => $thumbnail_id ? (string) get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) : '',
		);
	}

	if ( $features ) {
		return $features;
	}

	return array(
		array(
			'title' => 'Opieka instruktorów',
			'text'  => 'Doświadczeni instruktorzy zadbają o Twoje bezpieczeństwo.',
		),
		array(
			'title' => 'Nowoczesne tory',
			'text'  => 'Pełne wyposażenie i indywidualne stanowiska.',
		),
		array(
			'title' => 'Szeroki arsenał',
			'text'  => 'Broń krótka i długa — od klasyki po nowoczesność.',
		),
		array(
			'title' => 'Vouchery i imprezy',
			'text'  => 'Wieczory kawalerskie, eventy i prezenty.',
		),
	);
}

/**
 * Returns one of the four editable fallback icons.
 *
 * @param int $index Feature index.
 * @return string
 */
function gro_feature_icon_url( $index ) {
	$icons = array(
		'assets/icon-shield.svg',
		'assets/icon-target.svg',
		'assets/icon-glock-orange.png',
		'assets/icon-trophy.svg',
	);

	return get_theme_file_uri( $icons[ $index % count( $icons ) ] );
}

/**
 * Builds the editable hero pattern.
 *
 * @param array<string, mixed> $data Legacy hero values.
 * @return string
 */
function gro_build_hero_blocks( $data ) {

	$title = nl2br( esc_html( (string) $data['title'] ) );
	$copy  = gro_heading_block( $title, 1, array( 'className' => 'gro-hero__title' ) );
	$copy .= gro_paragraph_block( esc_html( (string) $data['text'] ), array( 'className' => 'gro-hero__lead' ) );

	$buttons  = gro_button_block( (string) $data['offer_label'], (string) $data['offer_url'] );
	$buttons .= gro_button_block( (string) $data['booking_label'], (string) $data['booking_url'], 'is-style-outline' );
	if ( '' !== $buttons ) {
		$copy .= gro_block( 'buttons', array( 'className' => 'gro-hero__actions' ), '<div class="wp-block-buttons gro-hero__actions">' . $buttons . '</div>' );
	}

	$copy = gro_block(
		'group',
		array(
			'className' => 'gro-hero__copy',
			'layout'    => array( 'type' => 'constrained' ),
		),
		'<div class="wp-block-group gro-hero__copy">' . $copy . '</div>'
	);

	$cover_attrs = array(
		'url'                => (string) $data['image_url'],
		'dimRatio'           => 20,
		'overlayColor'       => 'black',
		'isUserOverlayColor' => true,
		'focalPoint'         => array(
			'x' => 0.5,
			'y' => 0.5,
		),
		'minHeight'          => 540,
		'minHeightUnit'      => 'px',
		'contentPosition'    => 'center left',
		'anchor'             => 'oferta',
		'className'          => 'gro-hero',
		'align'              => 'wide',
	);
	if ( ! empty( $data['image_id'] ) ) {
		$cover_attrs['id'] = absint( $data['image_id'] );
	}

	$image = '<img class="wp-block-cover__image-background" alt="' . esc_attr( (string) $data['image_alt'] ) . '" src="' . esc_url( (string) $data['image_url'] ) . '" style="object-position:50% 50%" data-object-fit="cover" data-object-position="50% 50%"/>';
	$html  = '<div id="oferta" class="wp-block-cover alignwide has-custom-content-position is-position-center-left gro-hero" style="min-height:540px"><span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim-20 has-background-dim"></span>' . $image . '<div class="wp-block-cover__inner-container">' . $copy . '</div></div>';

	return gro_block( 'cover', $cover_attrs, $html );
}
/**
 * Builds the editable feature-card pattern.
 *
 * @param array<int, array<string, mixed>> $features Feature values.
 * @param string                           $label    Section label.
 * @return string
 */
function gro_build_features_blocks( $features, $label ) {

	$columns = '';
	foreach ( $features as $index => $feature ) {
		$image_url = empty( $feature['image_url'] ) ? gro_feature_icon_url( $index ) : (string) $feature['image_url'];
		$image_id  = empty( $feature['image_id'] ) ? 0 : absint( $feature['image_id'] );
		$image_alt = empty( $feature['image_alt'] ) ? '' : (string) $feature['image_alt'];

		$card     = gro_image_block( $image_url, $image_id, $image_alt, 'gro-feature-card__icon' );
		$card    .= gro_heading_block( esc_html( (string) $feature['title'] ), 3 );
		$card    .= gro_paragraph_block( esc_html( (string) $feature['text'] ) );
		$card     = gro_block(
			'group',
			array(
				'className' => 'gro-feature-card',
				'layout'    => array( 'type' => 'constrained' ),
			),
			'<div class="wp-block-group gro-feature-card">' . $card . '</div>'
		);
		$columns .= gro_block( 'column', array(), '<div class="wp-block-column">' . $card . '</div>' );
	}

	$heading = gro_heading_block( esc_html( $label ), 2, array( 'className' => 'gro-section-title' ) );
	$grid    = gro_block( 'columns', array( 'className' => 'gro-feature-grid' ), '<div class="wp-block-columns gro-feature-grid">' . $columns . '</div>' );

	return gro_block(
		'group',
		array(
			'tagName'   => 'section',
			'anchor'    => 'dlaczego',
			'className' => 'gro-features',
			'align'     => 'wide',
		),
		'<section id="dlaczego" class="wp-block-group alignwide gro-features">' . $heading . $grid . '</section>'
	);
}

/**
 * Builds four editable starter package cards.
 *
 * @return string
 */
function gro_build_packages_blocks() {

	$columns   = '';
	$image_url = get_theme_file_uri( 'hero.jpg' );

	for ( $index = 1; $index <= 4; $index++ ) {
		$card = gro_image_block( $image_url, 0, '', 'gro-package-card__image' );
		/* translators: %d: starter package number. */
		$card    .= gro_heading_block( sprintf( __( 'Pakiet %d', 'gun-resort-one' ), $index ), 3 );
		$card    .= gro_paragraph_block( __( 'Dla kogo: do uzupełnienia', 'gun-resort-one' ), array( 'className' => 'gro-package-card__audience' ) );
		$card    .= gro_paragraph_block( __( 'Opis pakietu i jego zawartość do uzupełnienia.', 'gun-resort-one' ) );
		$card    .= gro_block(
			'list',
			array( 'className' => 'gro-package-card__list' ),
			'<ul class="wp-block-list gro-package-card__list"><li>' . esc_html__( 'Element pakietu', 'gun-resort-one' ) . '</li><li>' . esc_html__( 'Liczba strzałów', 'gun-resort-one' ) . '</li></ul>'
		);
		$card    .= gro_paragraph_block( __( 'Cena do ustalenia', 'gun-resort-one' ), array( 'className' => 'gro-package-card__price' ) );
		$card    .= gro_block( 'buttons', array( 'className' => 'gro-package-card__actions' ), '<div class="wp-block-buttons gro-package-card__actions">' . gro_button_block( __( 'Rezerwuj', 'gun-resort-one' ), '#kontakt' ) . '</div>' );
		$card     = gro_block(
			'group',
			array(
				'className' => 'gro-package-card',
				'layout'    => array( 'type' => 'constrained' ),
			),
			'<div class="wp-block-group gro-package-card">' . $card . '</div>'
		);
		$columns .= gro_block( 'column', array(), '<div class="wp-block-column">' . $card . '</div>' );
	}

	$heading = gro_heading_block( __( 'Pakiety strzeleckie', 'gun-resort-one' ), 2, array( 'className' => 'gro-section-title' ) );
	$grid    = gro_block( 'columns', array( 'className' => 'gro-package-grid' ), '<div class="wp-block-columns gro-package-grid">' . $columns . '</div>' );

	return gro_block(
		'group',
		array(
			'tagName'   => 'section',
			'anchor'    => 'pakiety',
			'className' => 'gro-packages',
			'align'     => 'wide',
		),
		'<section id="pakiety" class="wp-block-group alignwide gro-packages">' . $heading . $grid . '</section>'
	);
}

/**
 * Builds the editable first-visit steps.
 *
 * @return string
 */
function gro_build_first_time_blocks() {

	$steps   = array(
		array( __( 'Wybierz pakiet', 'gun-resort-one' ), __( 'Wybierz pakiet dopasowany do swoich potrzeb.', 'gun-resort-one' ) ),
		array( __( 'Przyjdź z dokumentem', 'gun-resort-one' ), __( 'Przygotuj ważny dokument tożsamości.', 'gun-resort-one' ) ),
		array( __( 'Przejdź szkolenie', 'gun-resort-one' ), __( 'Instruktor omówi zasady bezpieczeństwa.', 'gun-resort-one' ) ),
	);
	$columns = '';

	foreach ( $steps as $index => $step ) {
		$content  = gro_paragraph_block( (string) ( $index + 1 ) . '.', array( 'className' => 'gro-step__number' ) );
		$content .= gro_heading_block( $step[0], 3 );
		$content .= gro_paragraph_block( $step[1] );
		$content  = gro_block(
			'group',
			array(
				'className' => 'gro-step',
				'layout'    => array( 'type' => 'constrained' ),
			),
			'<div class="wp-block-group gro-step">' . $content . '</div>'
		);
		$columns .= gro_block( 'column', array(), '<div class="wp-block-column">' . $content . '</div>' );
	}

	$heading = gro_heading_block( __( 'Pierwszy raz na strzelnicy?', 'gun-resort-one' ), 2, array( 'className' => 'gro-section-title' ) );
	$grid    = gro_block( 'columns', array( 'className' => 'gro-step-grid' ), '<div class="wp-block-columns gro-step-grid">' . $columns . '</div>' );

	return gro_block(
		'group',
		array(
			'tagName'   => 'section',
			'anchor'    => 'pierwszy-raz',
			'className' => 'gro-first-time',
			'align'     => 'wide',
		),
		'<section id="pierwszy-raz" class="wp-block-group alignwide gro-first-time">' . $heading . $grid . '</section>'
	);
}
/**
 * Collects the old home-page data and returns serialized block content.
 *
 * @return string
 */
function gro_build_migrated_front_page() {
	$hero_image_id  = absint( gro_legacy_mod( 'gro_hero_image' ) );
	$hero_image_url = $hero_image_id ? (string) wp_get_attachment_image_url( $hero_image_id, 'full' ) : get_theme_file_uri( 'hero.jpg' );
	$hero_image_alt = $hero_image_id ? (string) get_post_meta( $hero_image_id, '_wp_attachment_image_alt', true ) : '';

	$hero = array(
		'title'         => (string) gro_legacy_mod( 'gro_hero_title' ),
		'text'          => (string) gro_legacy_mod( 'gro_hero_text' ),
		'offer_label'   => (string) gro_legacy_mod( 'gro_offer_label' ),
		'offer_url'     => (string) gro_legacy_mod( 'gro_offer_url' ),
		'booking_label' => '',
		'booking_url'   => '',
		'image_id'      => $hero_image_id,
		'image_url'     => $hero_image_url,
		'image_alt'     => $hero_image_alt,
	);

	if ( gro_legacy_mod( 'gro_show_booking_cta' ) && gro_legacy_mod( 'gro_booking_url' ) ) {
		$hero['booking_label'] = (string) gro_legacy_mod( 'gro_booking_label' );
		$hero['booking_url']   = (string) gro_legacy_mod( 'gro_booking_url' );
	}

	return gro_build_hero_blocks( $hero )
		. gro_build_features_blocks( gro_collect_legacy_features(), (string) gro_legacy_mod( 'gro_features_label' ) )
		. gro_build_packages_blocks()
		. gro_build_first_time_blocks();
}

/**
 * Adds the 2.2 sections to a previously generated page without replacing edits.
 *
 * @param string $content Existing block content.
 * @return string
 */
function gro_upgrade_front_page_content( $content ) {

	$content = str_replace(
		array(
			'"className":"gro-hero","align":"wide","layout":{"type":"constrained"}',
			'"className":"gro-features","align":"wide","layout":{"type":"constrained"}',
			'"className":"gro-hero","layout":{"type":"constrained"}',
			'"className":"gro-features","layout":{"type":"constrained"}',
			'"anchor":"pakiety","className":"gro-features"',
			'<section id="pakiety" class="wp-block-group alignwide gro-features">',
			'"className":"screen-reader-text"',
			'class="wp-block-heading screen-reader-text"',
		),
		array(
			'"className":"gro-hero","align":"wide"',
			'"className":"gro-features","align":"wide"',
			'"className":"gro-hero","align":"wide"',
			'"className":"gro-features","align":"wide"',
			'"anchor":"dlaczego","className":"gro-features"',
			'<section id="dlaczego" class="wp-block-group alignwide gro-features">',
			'"className":"gro-section-title"',
			'class="wp-block-heading gro-section-title"',
		),
		$content
	);

	if ( false === strpos( $content, 'gro-packages' ) ) {
		$content .= gro_build_packages_blocks();
	}
	if ( false === strpos( $content, 'gro-first-time' ) ) {
		$content .= gro_build_first_time_blocks();
	}

	return $content;
}
/**
 * Finds an object created by a previous, interrupted migration attempt.
 *
 * @param string $post_type Post type.
 * @return int
 */
function gro_find_migration_post( $post_type ) {
	$posts = get_posts(
		array(
			'post_type'      => $post_type,
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_gro_block_migration_version',
			'meta_compare'   => 'EXISTS',
		)
	);

	return $posts ? absint( $posts[0] ) : 0;
}

/**
 * Creates the new front page as a draft.
 *
 * @return int|WP_Error
 */
function gro_create_migrated_front_page() {
	$page_id = gro_find_migration_post( 'page' );

	if ( $page_id ) {
		$page    = get_post( $page_id );
		$content = $page instanceof WP_Post ? (string) $page->post_content : '';
		$content = gro_upgrade_front_page_content( $content );
		$result  = wp_update_post(
			wp_slash(
				array(
					'ID'           => $page_id,
					'post_content' => $content,
				)
			),
			true
		);
	} else {
		$result = wp_insert_post(
			wp_slash(
				array(
					'post_type'    => 'page',
					'post_status'  => 'draft',
					'post_title'   => __( 'Strona główna', 'gun-resort-one' ),
					'post_name'    => 'strona-glowna-blokowa',
					'post_content' => gro_build_migrated_front_page(),
				)
			),
			true
		);
	}

	if ( ! is_wp_error( $result ) ) {
		update_post_meta( $result, '_gro_block_migration_version', GRO_BLOCK_MIGRATION_VERSION );
	}

	return $result;
}

/**
 * Removes the obsolete constrained layout from a generated header part.
 *
 * @param int $template_part_id Template part post ID.
 * @return int|WP_Error
 */
function gro_normalize_header_template_part( $template_part_id ) {
	$template_part = get_post( $template_part_id );
	if ( ! $template_part instanceof WP_Post ) {
		return new WP_Error( 'gro_missing_header', __( 'Nie znaleziono nagłówka Gun Resort.', 'gun-resort-one' ) );
	}

	$content = str_replace(
		'"className":"gro-site-header","layout":{"type":"constrained"}',
		'"className":"gro-site-header"',
		(string) $template_part->post_content
	);

	if ( $content === $template_part->post_content ) {
		return absint( $template_part_id );
	}

	return wp_update_post(
		wp_slash(
			array(
				'ID'           => $template_part_id,
				'post_content' => $content,
			)
		),
		true
	);
}

/**
 * Builds navigation-link blocks from the old primary menu or safe defaults.
 *
 * @return string
 */
function gro_build_navigation_links() {
	$links     = array();
	$locations = get_nav_menu_locations();

	if ( ! empty( $locations['primary'] ) ) {
		$items = wp_get_nav_menu_items( absint( $locations['primary'] ) );
		foreach ( (array) $items as $item ) {
			if ( 0 !== absint( $item->menu_item_parent ) ) {
				continue;
			}
			$links[] = array(
				'label'  => wp_strip_all_tags( $item->title ),
				'url'    => $item->url,
				'target' => '_blank' === $item->target ? '_blank' : '',
			);
		}
	}

	if ( ! $links ) {
		$links = array(
			array(
				'label' => __( 'Start', 'gun-resort-one' ),
				'url'   => home_url( '/' ),
			),
			array(
				'label' => __( 'Dlaczego my', 'gun-resort-one' ),
				'url'   => home_url( '/#dlaczego' ),
			),
			array(
				'label' => __( 'Pakiety', 'gun-resort-one' ),
				'url'   => home_url( '/#pakiety' ),
			),
			array(
				'label' => __( 'Pierwszy raz', 'gun-resort-one' ),
				'url'   => home_url( '/#pierwszy-raz' ),
			),
			array(
				'label' => __( 'Kontakt', 'gun-resort-one' ),
				'url'   => home_url( '/#kontakt' ),
			),
		);
	}

	$content = '';
	foreach ( $links as $link ) {
		$attrs = array(
			'label'          => $link['label'],
			'url'            => $link['url'],
			'kind'           => 'custom',
			'isTopLevelLink' => true,
		);
		if ( ! empty( $link['target'] ) ) {
			$attrs['opensInNewTab'] = true;
		}
		$content .= gro_void_block( 'navigation-link', $attrs );
	}

	return $content;
}

/**
 * Creates an editable Navigation entity.
 *
 * @return int|WP_Error
 */
function gro_create_navigation() {
	$navigation_id = gro_find_migration_post( 'wp_navigation' );
	$data          = array(
		'post_type'    => 'wp_navigation',
		'post_status'  => 'publish',
		'post_title'   => __( 'Menu główne', 'gun-resort-one' ),
		'post_content' => gro_build_navigation_links(),
	);

	if ( $navigation_id ) {
		$data['ID'] = $navigation_id;
		$result     = wp_update_post( wp_slash( $data ), true );
	} else {
		$result = wp_insert_post( wp_slash( $data ), true );
	}

	if ( ! is_wp_error( $result ) ) {
		update_post_meta( $result, '_gro_block_migration_version', GRO_BLOCK_MIGRATION_VERSION );
	}

	return $result;
}

/**
 * Builds an editable header using the migrated menu and utility information.
 *
 * @param int $navigation_id Navigation post ID.
 * @return string
 */
function gro_build_header_content( $navigation_id ) {
	$left  = gro_paragraph_block( '<a href="mailto:kontakt@gunresort.pl">kontakt@gunresort.pl</a>' );
	$left .= gro_paragraph_block( '<a href="mailto:praca@gunresort.pl">praca@gunresort.pl</a>' );
	$left  = gro_block(
		'group',
		array(
			'className' => 'gro-utility__left',
			'layout'    => array(
				'type'     => 'flex',
				'flexWrap' => 'wrap',
			),
		),
		'<div class="wp-block-group gro-utility__left">' . $left . '</div>'
	);

	$right  = gro_paragraph_block( '<a href="https://www.facebook.com/profile.php?id=61584019233226">Facebook</a>' );
	$right .= gro_paragraph_block( '<a href="https://www.instagram.com/strzelnicastrefa48/">Instagram</a>' );
	$right  = gro_block(
		'group',
		array(
			'className' => 'gro-utility__right',
			'layout'    => array(
				'type'           => 'flex',
				'flexWrap'       => 'wrap',
				'justifyContent' => 'right',
			),
		),
		'<div class="wp-block-group gro-utility__right">' . $right . '</div>'
	);

	$utility = gro_block(
		'group',
		array(
			'className' => 'gro-utility',
			'layout'    => array(
				'type'           => 'flex',
				'flexWrap'       => 'nowrap',
				'justifyContent' => 'space-between',
			),
		),
		'<div class="wp-block-group gro-utility">' . $left . $right . '</div>'
	);

	if ( has_custom_logo() ) {
		$brand = gro_void_block(
			'site-logo',
			array(
				'width'          => 210,
				'shouldSyncIcon' => true,
			)
		);
	} else {
		$brand = gro_image_block( add_query_arg( 'ver', GRO_THEME_VERSION, get_theme_file_uri( 'assets/logo-glock.png' ) ), 0, '', 'gro-brand__fallback-logo' );
	}
	$brand = gro_block(
		'group',
		array(
			'className' => 'gro-brand',
			'layout'    => array(
				'type'     => 'flex',
				'flexWrap' => 'nowrap',
			),
		),
		'<div class="wp-block-group gro-brand">' . $brand . '</div>'
	);

	$navigation = gro_void_block(
		'navigation',
		array(
			'ref'         => absint( $navigation_id ),
			'overlayMenu' => 'mobile',
			'className'   => 'gro-primary-navigation',
		)
	);
	$cta        = gro_block( 'buttons', array( 'className' => 'gro-header-cta' ), '<div class="wp-block-buttons gro-header-cta">' . gro_button_block( __( 'Rezerwuj', 'gun-resort-one' ), '#kontakt' ) . '</div>' );
	$main       = gro_block(
		'group',
		array(
			'className' => 'gro-main-nav',
			'layout'    => array(
				'type'     => 'flex',
				'flexWrap' => 'nowrap',
			),
		),
		'<div class="wp-block-group gro-main-nav">' . $brand . $navigation . $cta . '</div>'
	);

	return gro_block(
		'group',
		array( 'className' => 'gro-site-header' ),
		'<div class="wp-block-group gro-site-header">' . $utility . $main . '</div>'
	);
}

/**
 * Creates the database override for the editable header template part.
 *
 * @param int $navigation_id Navigation post ID.
 * @return int|WP_Error
 */
function gro_create_header_template_part( $navigation_id ) {
	$template_id = gro_find_migration_post( 'wp_template_part' );
	$data        = array(
		'post_type'    => 'wp_template_part',
		'post_status'  => 'publish',
		'post_title'   => __( 'Nagłówek', 'gun-resort-one' ),
		'post_name'    => 'header',
		'post_content' => gro_build_header_content( $navigation_id ),
	);

	if ( $template_id ) {
		$data['ID'] = $template_id;
		$result     = wp_update_post( wp_slash( $data ), true );
	} else {
		$result = wp_insert_post( wp_slash( $data ), true );
	}

	if ( is_wp_error( $result ) ) {
		return $result;
	}

	$theme_term = wp_set_object_terms( $result, get_stylesheet(), 'wp_theme' );
	if ( is_wp_error( $theme_term ) ) {
		return $theme_term;
	}
	wp_set_object_terms( $result, 'header', 'wp_template_part_area' );
	update_post_meta( $result, '_gro_block_migration_version', GRO_BLOCK_MIGRATION_VERSION );

	return $result;
}

/**
 * Executes the migration and switches the static front page last.
 *
 * @return int|WP_Error New front-page ID or an error.
 */
function gro_run_block_migration() {

	$page_id = gro_create_migrated_front_page();
	if ( is_wp_error( $page_id ) ) {
		return $page_id;
	}

	$navigation_id = gro_create_navigation();
	if ( is_wp_error( $navigation_id ) ) {
		return $navigation_id;
	}

	$template_part_id = gro_create_header_template_part( $navigation_id );
	if ( is_wp_error( $template_part_id ) ) {
		return $template_part_id;
	}
	$published = wp_update_post(
		array(
			'ID'          => $page_id,
			'post_status' => 'publish',
		),
		true
	);
	if ( is_wp_error( $published ) ) {
		return $published;
	}

	update_option(
		'gro_block_migration_backup',
		array(
			'show_on_front' => get_option( 'show_on_front' ),
			'page_on_front' => absint( get_option( 'page_on_front' ) ),
			'migrated_at'   => current_time( 'mysql', true ),
		),
		false
	);
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', absint( $page_id ) );
	update_option( 'gro_block_migration_version', GRO_BLOCK_MIGRATION_VERSION, false );

	return absint( $page_id );
}

/**
 * Runs the migration once for administrators after an upgrade or activation.
 */
function gro_maybe_migrate_to_blocks() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	if ( absint( get_option( 'gro_block_migration_version', 0 ) ) >= GRO_BLOCK_MIGRATION_VERSION ) {
		return;
	}

	$result = gro_run_block_migration();
	if ( is_wp_error( $result ) ) {
		set_transient( 'gro_block_migration_error', $result->get_error_message(), 5 * MINUTE_IN_SECONDS );
		return;
	}

	set_transient( 'gro_block_migration_notice', absint( $result ), 5 * MINUTE_IN_SECONDS );
}
add_action( 'init', 'gro_maybe_migrate_to_blocks', 100 );

/**
 * Shows the migration result once, with a direct link to the block editor.
 */
function gro_block_migration_notice() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$error = get_transient( 'gro_block_migration_error' );
	if ( $error ) {
		delete_transient( 'gro_block_migration_error' );
		echo '<div class="notice notice-error"><p><strong>' . esc_html__( 'Migracja Gun Resort nie została ukończona.', 'gun-resort-one' ) . '</strong> ' . esc_html( $error ) . '</p></div>';
		return;
	}

	$page_id = absint( get_transient( 'gro_block_migration_notice' ) );
	if ( ! $page_id ) {
		return;
	}

	delete_transient( 'gro_block_migration_notice' );
	$url = admin_url( 'post.php?post=' . $page_id . '&action=edit' );
	echo '<div class="notice notice-success is-dismissible"><p><strong>' . esc_html__( 'Strona Gun Resort została przeniesiona do bloków.', 'gun-resort-one' ) . '</strong> <a href="' . esc_url( $url ) . '">' . esc_html__( 'Edytuj stronę główną', 'gun-resort-one' ) . '</a></p></div>';
}
add_action( 'admin_notices', 'gro_block_migration_notice' );
