<?php
/**
 * Title: Cztery kafelki Gun Resort
 * Slug: gun-resort-one/features
 * Categories: gun-resort, columns
 * Description: Cztery swobodnie edytowalne kafelki z ikonami, tytułami i opisami.
 * Inserter: yes
 */

echo gro_build_features_blocks( gro_collect_legacy_features(), (string) gro_legacy_mod( 'gro_features_label' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Block builder escapes dynamic values.
