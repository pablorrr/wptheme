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
 * Change number of products per row to 3
 * source : https://docs.woocommerce.com/document/change-number-of-products-per-row/
 * Notice that number of products per row cant be greather than products number per page!!!!!! fix that!!!
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
 * source : https://docs.woocommerce.com/document/storefront-filters-example-change-number-products-displayed-per-page/
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
 * Display category image on category archive
 * source :https://docs.woocommerce.com/document/woocommerce-display-category-image-on-category-archive/
 */
remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
add_action('woocommerce_archive_description', 'woocommerce_category_image', 2);
function woocommerce_category_image()
{
    if (is_product_category()) {
        global $wp_query;
        /////////////taken from wc-template-function (woocommerce plugin) line no 818
        if (is_product_taxonomy() && 0 === absint(get_query_var('paged'))) {
            $term = get_queried_object();

            if ($term && !empty($term->description)) {
                echo '<div class="term-description">' . wc_format_content($term->description) . '</div>'; // WPCS: XSS ok.
            }
        }
        /////////
        $cat = $wp_query->get_queried_object();
        $thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);
        $image = wp_get_attachment_url($thumbnail_id);
        if ($image) {
            echo '<div class="cat_details">   <img src="' . $image . '" alt="' . $cat->name . '" /></div>';
        }
    }
}

//remove sidebar from cart page

function _remove_sidebar_cart()
{
    if (is_cart() || is_account_page() || is_checkout() || is_product_category()) {//use phhp html bufer obget clean
        ?>
        <style>
            #right-sidebar, #footerfull, #left-sidebar, #statichero, #hero {
                display: none;
            }

            #content > div > ul {
                margin-top: 3em;
            !important
            }
        </style>
    <?php }
}

add_action('wp_head', '_remove_sidebar_cart');

/**
 * Set a minimum order amount for checkout
 * taken from :https://docs.woocommerce.com/document/minimum-order-amount/
 *
 */
add_action('woocommerce_checkout_process', 'wc_minimum_order_amount');
add_action('woocommerce_before_cart', 'wc_minimum_order_amount');

function wc_minimum_order_amount()
{
    // Set this variable to specify a minimum order value
    $minimum = 50;

    if (WC()->cart->total < $minimum) {

        if (is_cart()) {

            wc_print_notice(
                sprintf('Your current order total is %s — you must have an order with a minimum of %s to place your order ',
                    wc_price(WC()->cart->total),
                    wc_price($minimum)
                ), 'error'
            );

        } else {

            wc_add_notice(
                sprintf('Your current order total is %s — you must have an order with a minimum of %s to place your order',
                    wc_price(WC()->cart->total),
                    wc_price($minimum)
                ), 'error'
            );

        }
    }
}

/**
 * Adjust the quantity input values, set up max and min quantity value which customer can order on single product page
 * taken from https://docs.woocommerce.com/document/adjust-the-quantity-input-values/
 */
add_filter('woocommerce_quantity_input_args', 'wptheme_woocommerce_quantity_input_args', 10, 2); // Simple products

function wptheme_woocommerce_quantity_input_args($args, $product)
{
    if (is_singular('product')) {
        $args['input_value'] = 4;    // Starting value (we only want to affect product pages, not cart)
    }
    $args['max_value'] = 50;    // Maximum value
    $args['min_value'] = 4;    // Minimum value
    $args['step'] = 2;    // Quantity steps
    return $args;
}

add_filter('woocommerce_available_variation', 'wptheme_woocommerce_available_variation');
// Variations

function wptheme_woocommerce_available_variation($args)
{
    $args['max_qty'] = 50;        // Maximum value (variations)
    $args['min_qty'] = 4;    // Minimum value (variations)
    return $args;
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
 
