<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wptheme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-thumbnail">

        <?php
        if (has_post_thumbnail()) {
            the_post_thumbnail('about-us-size');
        }
        ?>
    </div>
    <header class="entry-header">
        <?php
        if (is_single()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;

        ?>
    </header><!-- .entry-header -->
    <div class="entry-content">
        <?php
        if (is_single()) :
            the_content();
        else :
            the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'wptheme'));
        endif;

        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'wptheme'),
            'after' => '</div>',
        ));
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php
        //get meta value
        // echo  get_post_meta(get_the_ID(),'_my_meta_value_key', true );
        $hyperLink = get_post_meta($post->ID, '_hyperlink_meta_value_key', true);
        $blankAttr = '_blank';
        $ltrimHyperlink = ltrim($hyperLink, 'http://');
        printf('<p><a href="%1$s" target="%2$s">%3$s</a></p>',
            esc_url($hyperLink), esc_attr($blankAttr), esc_html($ltrimHyperlink));
        ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->
