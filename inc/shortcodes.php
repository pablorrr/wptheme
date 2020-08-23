<?php 
/**
 * 
 * Shortcodes
 * 
 * url source: https://codex.wordpress.org/Shortcode_API
 *
 * @package wptheme
 */
 
/* Bootstrap Tootlip */

function wptheme_tooltip_shortcode( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'placement' => 'top',
			'title' => '',
	), $atts );
$title = ( $a['title'] == '' ? $content : $a['title'] );	
return '<span  data-toggle="tooltip" data-placement="' . $a['placement'] . '" title="' . $title . '">' . $content . '</span>';
}
add_shortcode( 'tooltip', 'wptheme_tooltip_shortcode' );

/* example usage [tooltip placement="top" title="hover content"]content[/tooltip]
mouse cover text to see result */


/* Bootstrap Popover */ 
function wptheme_popover( $atts, $content = null ) {
	
	
	$atts = shortcode_atts(
		array(
			'placement' => 'left',
			'title' => '',
			'trigger' => 'click',
			'content' => '',
		),
		$atts,
		'popover'
	);
	
	//return HTML
	return '<span data-toggle="popover" data-placement="' . $atts['placement'] . '" title="' . $atts['title'] . '" data-trigger="' . $atts['trigger'] . '" data-content="' . $atts['content'] . '">' . $content . '</span>';
		
}
/* example usage :[popover placement="right" title="popover title"
content="popover content"] popover content[/popover]- mouse click text to see result*/
add_shortcode( 'popover', 'wptheme_popover' );
?>