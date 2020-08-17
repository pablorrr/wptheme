<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package wptheme
 */

if ( ! function_exists( 'wptheme_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Function is invoking in content files located in Template Parts folder
 */
function wptheme_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'wptheme' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'wptheme' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span> | <span class="byline"> ' . $byline . '</span>'; 
	// WPCS: XSS OK.

    if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo ' | <span class="comments-link"><i class="fa fa-comments" aria-hidden="true"></i> ';
        /* translators: %s: post title */
        comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'wptheme' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
        echo '</span>';
    }

}
endif;

if ( ! function_exists( 'wptheme_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function wptheme_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'wptheme' ) );
		if ( $categories_list && wptheme_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'wptheme' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'wptheme' ) );
		if ( $tags_list ) {
			printf( ' | <span class="tags-links">' . esc_html__( 'Tagged %1$s', 'wptheme' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}


	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'wptheme' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		' | <span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function wptheme_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'wptheme_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'wptheme_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so wp_bootstrap_starter_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so wp_bootstrap_starter_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in wptheme_categorized_blog.
 */
function wptheme_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'wptheme_categories' );
}
add_action( 'edit_category', 'wptheme_category_transient_flusher' );
add_action( 'save_post',     'wptheme_category_transient_flusher' );



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

/* add font styles , Google Fonts Supporting*/
if (! function_exists('wptheme_add_font_styles')){
	
 function wptheme_add_font_styles(){

		
	}
	add_action ('wp_head','wptheme_add_font_styles'); 
}

/* Add to body tag layout class */



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

/* svg support */
/* source :https://codex.wordpress.org/Plugin_API/Filter_Reference/upload_mimes */
function my_custom_mime_types( $mimes ) {
	
        // New allowed mime types.
        $mimes['svg'] = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
        $mimes['doc'] = 'application/msword'; 

        // Optional. Remove a mime type.
       // unset( $mimes['exe'] );

	return $mimes;
}
add_filter( 'upload_mimes', 'my_custom_mime_types' );