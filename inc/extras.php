<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package wptheme
 */



/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function wptheme_pingback_header() {
	if ( is_single() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'wptheme_pingback_header' );