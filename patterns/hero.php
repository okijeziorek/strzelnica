<?php
/**
 * Title: Hero Gun Resort
 * Slug: gun-resort-one/hero
 * Categories: gun-resort, featured
 * Description: Dwukolumnowa sekcja otwierająca z obrazem i przyciskami.
 * Inserter: yes
 */

$defaults = gro_legacy_defaults();

echo gro_build_hero_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Block builder escapes dynamic values.
	array(
		'title'         => $defaults['gro_hero_title'],
		'text'          => $defaults['gro_hero_text'],
		'offer_label'   => $defaults['gro_offer_label'],
		'offer_url'     => $defaults['gro_offer_url'],
		'booking_label' => $defaults['gro_booking_label'],
		'booking_url'   => '#kontakt',
		'image_id'      => 0,
		'image_url'     => get_theme_file_uri( 'hero.jpg' ),
		'image_alt'     => '',
	)
);
