<?php
/**
 * source https://developer.wordpress.org/reference/functions/add_meta_box/
 *
 * Calls the class on the post edit screen.
 */
function wpthemeCall_metaboxClass()
{
    new metaboxClass();
}

if (is_admin()) {
    add_action('load-post.php', 'wpthemeCall_metaboxClass');
    add_action('load-post-new.php', 'wpthemeCall_metaboxClass');
}

require get_template_directory() . '/inc/metaboxClass.php';

