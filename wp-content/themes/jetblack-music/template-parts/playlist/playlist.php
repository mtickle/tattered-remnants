<?php
/**
 * Template part for displaying Hero Content
 *
 * @package JetBlack
 */

$jetblack_enable = jetblack_gtm( 'jetblack_playlist_visibility' );

if ( ! jetblack_display_section( $jetblack_enable ) ) {
	return;
}

get_template_part( 'template-parts/playlist/content-playlist' );
