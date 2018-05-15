<?php

// custom related products
// see: http://docs.woothemes.com/document/change-number-of-related-products-output/
function woocommerce_output_related_products() {
	woocommerce_related_products(3, 3);
	// Display 3 products in rows of 1
}

// Change number products to show
function st_wc_numb_pro_per_page() {
	return 12;
}

add_filter('loop_shop_per_page', 'st_wc_numb_pro_per_page', 20);

if (!function_exists('woocommerce_content')) {

	/**
	 * Output WooCommerce content.
	 *
	 * This function is only used in the optional 'woocommerce.php' template
	 * which people can add to their themes to add basic woocommerce support
	 * without hooks or modifying core templates.
	 *
	 * @access public
	 * @return void
	 */
	function woocommerce_content() {

		if (is_product()) {
			woocommerce_get_template('single-product.php');
			//  archive-product.php
		} elseif (is_product_category()) {
			woocommerce_get_template('taxonomy-product_cat.php');
			//  archive-product.php
		} elseif (is_product_tag()) {
			woocommerce_get_template('taxonomy-product_tag.php');
			//  archive-product.php
		} else {
			woocommerce_get_template('archive-product.php');
		}

	}

}

/**
 * Hook in on activation
 */
global $pagenow;
if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php')
	add_action('init', 'st_wc_image_dimensions', 1);

/**
 * Define image sizes
 */
function st_wc_image_dimensions() {
	$catalog = array(
	    'width' => '642', // px
		'height' => '999999', // px
		'crop' => 1 // true
	);

	$single = array(
	    'width' => '642', // px
		'height' => '999999', // px
		'crop' => 1 // true
	);

	$thumbnail = array(
	    'width' => '120', // px
		'height' => '120', // px
		'crop' => 0 // false
	);

	// Image sizes
	update_option('shop_catalog_image_size', $catalog);
	// Product category thumbs
	update_option('shop_single_image_size', $single);
	// Single product image
	//update_option('shop_thumbnail_image_size', $thumbnail);
	// Image gallery thumbs
}

 //st_woocommerce_image_dimensions();
 

global $woocommerce_loop;
$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 ); // only show 3 column
  

if ( ! function_exists( 'woocommerce_get_sidebar' ) ) {

	/**
	 * Get the shop sidebar template.
	 *
	 * @access public
	 * @return void
	 */
	function woocommerce_get_sidebar() {
		?>
		<div class="right-sidebar-wrapper four columns b0">
            <div class="right-sidebar sidebar">
                <?php 
                   dynamic_sidebar('st_shop'); 
                ?>
                <div class="clear"></div>
            </div>
        </div>
		<?php
		
	}
}


if ( ! function_exists( 'woocommerce_output_content_wrapper' ) ) {

	/**
	 * Output the start of the page wrapper.
	 *
	 * @access public
	 * @return void
	 */
	function woocommerce_output_content_wrapper() {
		?>
		<div class="content-wrapper eight columns b0">
		<?php 
	}
}
if ( ! function_exists( 'woocommerce_output_content_wrapper_end' ) ) {

	/**
	 * Output the end of the page wrapper.
	 *
	 * @access public
	 * @return void
	 */
	function woocommerce_output_content_wrapper_end() {
		?>
		</div>
		<?php 
	}
}

function st_wc_before_shop_loop_item(){
	 echo ' <div class="product-wrap">';
}

function st_wc_after_shop_loop_item(){
	 echo ' </div> ';
}


add_action('woocommerce_before_shop_loop_item', 'st_wc_before_shop_loop_item');
add_action('woocommerce_after_shop_loop_item', 'st_wc_after_shop_loop_item'); 



