<?php
/**
 * Add WooCommerce support
 * */

/**
 *
 * Add custom CSS
 *  Taken from: https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 * Enqueue your own stylesheet
 */
function wp_enqueue_woocommerce_style()
{
    wp_register_style('css-woocommerce', get_template_directory_uri() . '/css/woocommerce.css');

    if (class_exists('woocommerce') && (is_woocommerce())) {
        wp_enqueue_style('css-woocommerce');
    }
}

add_action('wp_enqueue_scripts', 'wp_enqueue_woocommerce_style');

add_action('after_setup_theme', 'wptheme_woocommerce_support');
if (!function_exists('wptheme_woocommerce_support')) {
    /**
     * Declares WooCommerce theme support.
     */
    function wptheme_woocommerce_support()
    {
        add_theme_support('woocommerce');

        // Add New Woocommerce 3.0.0 Product Gallery support
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-slider');


    }
}

/**
 * Change number of products per row to default  3
 * source : https://docs.woocommerce.com/document/change-number-of-products-per-row/
 *
 */

add_filter('loop_shop_columns', 'loop_columns', 20, 1);
if (!function_exists('loop_columns')) {
    function loop_columns($prod_per_row)
    {
        $prod_per_row = get_option('prdt_count_per_row');
        return $prod_per_row ? $prod_per_row : 3;
    }
}


/**
 * Change number of products per page (pagination)
 * source : https://docs.woocommerce.com/document/change-number-of-products-displayed-per-page/
 */

add_filter('loop_shop_per_page', 'products_count_per_page', 30, 1);
if (!function_exists('products_count_per_page')) {
    function products_count_per_page($prod_per_page)
    {
        $prod_per_page = get_option('prdt_count_per_page');
        return $prod_per_page ? $prod_per_page : 4;
    }
}
/**
 *
 * woocommerce docs source online :https://docs.woocommerce.com/document/adding-a-section-to-a-settings-tab/
 */

add_filter( 'woocommerce_get_sections_products', 'products_display_setup' );
function products_display_setup( $sections ) {

    $sections['wcproddissetup'] = __( 'Products display setup', 'wptheme' );
    return $sections;

}

/**
 * Add settings to the specific section we created before
 * To retrive option val use:get_option( 'id_name_of_field' )
 * https://docs.woocommerce.com/document/adding-a-section-to-a-settings-tab/
 */
add_filter( 'woocommerce_get_settings_products', 'wcslider_all_settings', 10, 2 );
function wcslider_all_settings( $settings, $current_section ) {
    /**
     * Check the current section is what we want
     **/
    if ( $current_section == 'wcproddissetup' ) {
        $settings_display_products = array();

        // Add text field option - Display products number per row
        $settings_display_products[] = array(
            'name'     => __( 'Display products number per row', 'wptheme' ),
            'desc_tip' => __( 'Type max number of products to display per row ', 'wptheme' ),
            'id'       => 'prdt_count_per_row',
            'type'     => 'text',
            'css'      => 'min-width:300px;',
            'desc'     => __( 'Max number of products per row', 'wptheme' ),
        );
        // Add text field option - Display products number per page
        $settings_display_products[] = array(
            'name'     => __( 'Display products number per page', 'wptheme' ),
            'desc_tip' => __( 'Type number of products to display per page ', 'wptheme' ),
            'id'       => 'prdt_count_per_page',
            'type'     => 'text',
            'css'      => 'min-width:300px;',
            'desc'     => __( 'Number of products per page', 'wptheme' ),
        );




        $settings_display_products[] = array( 'type' => 'sectionend', 'id' => 'wcproddissetup' );

        return $settings_display_products;

        /**
         * If not, return the standard settings
         **/
    } else {
        return $settings;
    }
}


/**
 * Display category image on category archive
 * source :https://docs.woocommerce.com/document/woocommerce-display-category-image-on-category-archive/
 */

add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
function woocommerce_category_image() {
    if ( is_product_category() ){
        global $wp_query;
        $cat = $wp_query->get_queried_object();
        $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
        $image = wp_get_attachment_url( $thumbnail_id );
        if ( $image ) {
            echo '<img src="' . $image . '" alt="' . $cat->name . '" />';
        }
    }
}
/*
 * Display on cart page link to shop page at the bottom
 *
 */
add_action('woocommerce_after_cart', 'wptheme_add_link_shop');

function wptheme_add_link_shop()
{

    if (!is_cart()) {
        echo '<a style="font-size:1.2em;" 
									href="' . esc_url(wc_get_page_permalink('cart')) . '" >'.__('Go to Cart page','wptheme').'
								<i class="fa fa-shopping-cart"></i></a>';
    }
    if (!is_shop()) {
        echo '<a style="font-size:1.2em;"  
								href="' . esc_url(wc_get_page_permalink('shop')) . '" >'.__('Go to Shop page','wptheme').'
								<i class="fa fa-shopping-bag"></i></a>';
    }

}

/*
 * Display shop link in product page with icon
 *
 */
add_action('woocommerce_after_single_product', 'wp_theme_display_shop_page_link', 5);

function wp_theme_display_shop_page_link()
{
    echo '<a style="font-size:1.2em;"  
								href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '" >Go to Shop page
								<i class="fa fa-shopping-bag"></i></a>';
}

/*
 * Print title on single product page at  top
 *
 */

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
add_action('woocommerce_before_single_product', 'woocommerce_template_single_title', 15);
 
