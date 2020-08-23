<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package wptheme
 */

if ( ! function_exists( 'wptheme_comments_feed_template_callback' ) ) :
    /**
     * Template for comments and pingbacks.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     */
    /* comments form callback function */

function wptheme_comments_feed_template_callback($comment, $args, $depth) {

  $GLOBAL['comment'] = $comment;

  ?> <br>
    <div class="row media">
      <a href="<?php get_comment_author_url(); ?>" class="pull-left"></a>
      <div class="col-md-12 media-body">
        <h5 class="media-heading">
          <a href="<?php get_comment_author_url(); ?>"><?php echo get_comment_author(); ?></a>
          <small><?php comment_date(); ?> at <?php comment_time(); ?></small>
        </h5>
		<br>
        <?php comment_text(); ?>
        <?php comment_reply_link(array_merge($args, array(
		  'reply_text' => __('<strong class="btn-lg fr-end-butt">Answer </strong><i class="icon-share-alt"></i>','wptheme'),
          'depth' => $depth,
          'max_depth' => $args['max_depth']
        ))); ?>
      </div>
    </div>
    <hr>
  <?php
}

endif;
/* Modify link class into Bootstrap classs */
add_filter('comment_reply_link', 'wptheme_add_reply_link_class');

function wptheme_add_reply_link_class($class) {
  $class = str_replace("class='comment-reply-link", "class='btn btn-default pull-right", $class);
  return $class;
}

add_filter( 'preprocess_comment', 'wptheme_comment_limitation' );

/* limit comments char */
function wptheme_comment_limitation($comment) {
    if ( strlen( $comment['comment_content'] ) > 800 ) {
        wp_die('Comment is too long. Please keep your comment under 250 characters.');
    }
if ( strlen( $comment['comment_content'] ) < 60 ) {
        wp_die('Comment is too short. Please use at least 60 characters.');
    }
    return $comment;
}

/* password protection for protected posts */
function wptheme_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    <div class="d-block mb-3">' . __( "To view this protected post, enter the password below:", "wptheme" ) . '</div>
    <div class="form-group form-inline"><label for="' . $label . '" class="mr-2">' . __( "Password:", "wptheme" ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" class="form-control mr-2" /> <input type="submit" name="Submit" value="' . esc_attr__( "Submit", "wptheme" ) . '" class="btn btn-primary"/></div>
    </form>';
    return $o;
}
add_filter( 'the_password_form', 'wptheme_password_form' );

/* https://codex.wordpress.org/Dashboard_Widgets_API */

function wptheme_dashboard_widget() {
 	wp_add_dashboard_widget(
							'wptheme_dashboard_widget',// Widget slug.
							'wptheme Dashboard Widget',// Title.
							'wptheme_dashboard_widget_function'// Display function.
							);
 	
 	
 	global $wp_meta_boxes;
 	// Get the regular dashboard widgets array
 	// (which has our new widget already but at the end)
    $normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
    // Backup and delete our new dashboard widget from the end of the array
    $culinary_widget_backup = array( 'wptheme_dashboard_widget' => $normal_dashboard['wptheme_dashboard_widget'] );
 	unset( $normal_dashboard['culinary_dashboard_widget'] );
 
 	// Merge the two arrays together so our widget is at the beginning
    $sorted_dashboard = array_merge( $culinary_widget_backup, $normal_dashboard );
    // Save the sorted array back into the original metaboxes
    $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
}
add_action( 'wp_dashboard_setup', 'wptheme_dashboard_widget' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function wptheme_dashboard_widget_function() {

    echo "Welcome in WpTheme , enjoy it!!! <br>
			<br>
			In this theme you can:<br>
			<br>
			- print phone number<br>
            - print opening time<br>
			- sell products(WC integrate)<br>
			
			
			<br>
			and set some additional options.<br>
			<br>";
}

/* Redirect to Home Page after logout */
add_action( 'wp_logout', 'wptheme_auto_redirect_external_after_logout');

function wptheme_auto_redirect_external_after_logout(){
		wp_redirect( home_url() );
		exit();
		}
		
		
/* Add to menu class to scroll page with menu */
function wptheme_add_specific_menu_location_atts( $atts, $item, $args ) {
    // check if the item is in the primary menu
    if( $args->theme_location == 'primary' ) {
      // add the desired attributes:
      $atts['class'] = 'nav-link js-scroll-trigger';
    }
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'wptheme_add_specific_menu_location_atts', 10, 3 );