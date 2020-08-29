<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wptheme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    </header><!-- .entry-header -->


    <div class="entry-content">
        <?php
        the_content();

        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'wptheme'),
            'after' => '</div>',
        ));
        ?>
    </div><!-- .entry-content -->

    <?php if (get_edit_post_link()) : ?>
        <footer class="entry-footer">
            <?php
            edit_post_link(
                sprintf(
                /* translators: %s: Name of current post */
                    esc_html__('Edit %s', 'wptheme'),
                    the_title('<span class="screen-reader-text">"', '"</span>', false)
                ),
                '<span class="edit-link">',
                '</span>'
            );

            //get meta value
            // echo  get_post_meta(get_the_ID(),'_my_meta_value_key', true );
            $hyperLink = get_post_meta($post->ID, '_hyperlink_meta_value_key', true);
            $blankAttr = '_blank';
            $ltrimHyperlink = ltrim($hyperLink, 'http://');
            printf('<p><a href="%1$s" target="%2$s">%3$s</a></p>',
                esc_url($hyperLink), esc_attr($blankAttr), esc_html($ltrimHyperlink));
            ?>

        </footer><!-- .entry-footer -->
    <?php endif; ?>
</article><!-- #post-## -->
