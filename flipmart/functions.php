<?php

//*** Support Title Tag 
add_theme_support( 'title-tag' );

//*** Enqueue FlipMart Scripts
function flipmart_enqueue_scripts(){
	
	wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/assets/css/bootstrap.min.css', array(), '3.2.0' );
		
	wp_enqueue_style( 'main', get_template_directory_uri().'/assets/css/main.css', array(), '1.0' );
	
	wp_enqueue_style( 'blue', get_template_directory_uri().'/assets/css/blue.css', array(), '1.0' );
	
	wp_enqueue_style( 'owl.carousel', get_template_directory_uri().'/assets/css/owl.carousel.css', array(), '1.0' );
	
	wp_enqueue_style( 'owl.transitions', get_template_directory_uri().'/assets/css/owl.transitions.css', array(), '1.0' );
	
	wp_enqueue_style( 'animate.min', get_template_directory_uri().'/assets/css/animate.min.css', array(), '1.0' );
	
	wp_enqueue_style( 'rateit', get_template_directory_uri().'/assets/css/rateit.css', array(), '1.0' );
	
	wp_enqueue_style( 'bootstrap-select.min', get_template_directory_uri().'/assets/css/bootstrap-select.min.css', array(), '1.0' );
	
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/assets/css/font-awesome.css', array(), '1.0' );
	
	// Theme stylesheet.
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	
	// WP Latest JQuery
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'bootstrap.min', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), '1.0.0', true );
	
	wp_enqueue_script( 'bootstrap-hover-dropdown.min', get_template_directory_uri() . '/assets/js/bootstrap-hover-dropdown.min.js', array(), '1.0.0', true );
	
	wp_enqueue_script( 'owl.carousel.min', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), '1.0.0', true );
	
	wp_enqueue_script( 'echo.min', get_template_directory_uri() . '/assets/js/echo.min.js', array(), '1.0.0', true );
	
	wp_enqueue_script( 'jquery.easing', get_template_directory_uri() . '/assets/js/jquery.easing-1.3.min.js', array(), '1.0.0', true );
	
	wp_enqueue_script( 'bootstrap-slider.min', get_template_directory_uri() . '/assets/js/bootstrap-slider.min.js', array(), '1.0.0', true );
	
	wp_enqueue_script( 'jquery.rateit.min', get_template_directory_uri() . '/assets/js/jquery.rateit.min.js', array(), '1.0.0', true );
	
	wp_enqueue_script( 'lightbox.min', get_template_directory_uri() . '/assets/js/lightbox.min.js', array(), '1.0.0', true );

	wp_enqueue_script( 'bootstrap-select.min', get_template_directory_uri() . '/assets/js/bootstrap-select.min.js', array(), '1.0.0', true );
	
	wp_enqueue_script( 'wow.min', get_template_directory_uri() . '/assets/js/wow.min.js', array(), '1.0.0', true );
	
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), '1.0.0', true );
	

}

add_action('wp_enqueue_scripts','flipmart_enqueue_scripts');


// WooCommerce Theme Support 

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}


add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );
/**
 * custom_woocommerce_template_loop_add_to_cart
*/
function custom_woocommerce_product_add_to_cart_text() {
	global $product;
	
	$product_type = $product->product_type;
	
	switch ( $product_type ) {
		case 'external':
			return __( 'Buy product', 'woocommerce' );
		break;
		case 'grouped':
			return __( 'View products', 'woocommerce' );
		break;
		case 'simple':
			return __( 'Add to cart', 'woocommerce' );
		break;
		case 'variable':
			return __( 'Select options', 'woocommerce' );
		break;
		default:
			return __( 'Read more', 'woocommerce' );
	}
	
}
// Change woocommerce defaults breadcrumb
add_filter( 'woocommerce_breadcrumb_defaults', 'flipmart_woocommerce_breadcrumbs' );
function flipmart_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => ' &#47; ',
            'wrap_before' => '<div class="breadcrumb-inner">
          <ul class="list-inline list-unstyled">',
            'wrap_after'  => '</ul>
        </div>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
        );
}


// Add remove woocommerce defaults functions
add_action( 'init', 'flipmart_add_remove_woocommerce_defaults_functions' );
function flipmart_add_remove_woocommerce_defaults_functions() {
	
	// Shop page
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10, 0 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30, 0 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20, 0 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	 
	// Single page
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	
}

// Remove list/grid view plugin default option
function flipmart_listgrid_plugin_option(){
   global $WC_List_Grid;
   remove_action( 'woocommerce_before_shop_loop', array( $WC_List_Grid, 'gridlist_toggle_button' ), 30); 
}
add_action('woocommerce_archive_description','flipmart_listgrid_plugin_option');



function flipmart_pagination() {

global $wp_query;

$big = 999999999; // need an unlikely integer

$pages = paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages,
        'type'  => 'array',
		'prev_next'          => true,
		'prev_text'          => __('<i class="fa fa-angle-left"></i>'),
		'next_text'          => __('<i class="fa fa-angle-right"></i>'),

    ) );
    if( is_array( $pages ) ) {
        $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        echo '<div class="pagination-container"><ul class="list-inline list-unstyled">';
        foreach ( $pages as $page ) {
                echo "<li>$page</li>";
        }
       echo '</ul></div>';
        }
}

// WooCommerce shop page show per page drop down

function flipmart_woocommerce_catalog_page_ordering() {
?>
<div class="lbl-cnt">
<?php echo '<span class="lbl">Show</span>' ?>
<form action="" method="POST" name="results" class="fld inline">
<select name="woocommerce-sort-by-columns" id="woocommerce-sort-by-columns" class="sortby" onchange="this.form.submit()">
<?php
//Get products on page reload
if  (isset($_POST['woocommerce-sort-by-columns']) && (($_COOKIE['shop_pageResults'] <> $_POST['woocommerce-sort-by-columns']))) {
$numberOfProductsPerPage = $_POST['woocommerce-sort-by-columns'];
} else {
$numberOfProductsPerPage = $_COOKIE['shop_pageResults'];
}
//  This is where you can change the amounts per page that the user will use  feel free to change the numbers and text as you want, in my case we had 4 products per row so I chose to have multiples of four for the user to select.
$shopCatalog_orderby = apply_filters('woocommerce_sortby_page', array(
//Add as many of these as you like, -1 shows all products per page
//  ''       => __('Results per page', 'woocommerce'),
'12' 		=> __('12', 'flipmart'),
'20' 		=> __('20', 'flipmart'),
'30' 		=> __('30', 'flipmart'),
'40' 		=> __('40', 'flipmart'),
'50' 		=> __('50', 'flipmart'),
'-1' 		=> __('All', 'flipmart'),
));
foreach ( $shopCatalog_orderby as $sort_id => $sort_name )
echo '<option value="' . $sort_id . '" ' . selected( $numberOfProductsPerPage, $sort_id, true ) . ' >' . $sort_name . '</option>';
?>
</select>
</form>
</div>
<?php
}
// now we set our cookie if we need to
function dl_sort_by_page($count) {
if (isset($_COOKIE['shop_pageResults'])) { // if normal page load with cookie
$count = $_COOKIE['shop_pageResults'];
}
if (isset($_POST['woocommerce-sort-by-columns'])) { //if form submitted
setcookie('shop_pageResults', $_POST['woocommerce-sort-by-columns'], time()+1209600, '/', 'www.your-domain-goes-here.com', false); //this will fail if any part of page has been output- hope this works!
$count = $_POST['woocommerce-sort-by-columns'];
}
// else normal page load and no cookie
return $count;
}
add_filter('loop_shop_per_page','dl_sort_by_page');


// WooCommerce custom catalog ordering 
add_filter( 'woocommerce_catalog_orderby', 'flipmart_custom_woocommerce_catalog_orderby' );
function flipmart_custom_woocommerce_catalog_orderby( $sortby ) {
	$sortby['menu_order'] = 'Position';
	$sortby['price'] = 'Price:Lowest first';
	$sortby['price-desc'] = 'Price:HIghest first';
	unset($sortby['popularity']);
	unset($sortby['date']);
	unset($sortby['rating']);
	
	return $sortby;
}



// FlipMart sidebar register
add_action( 'widgets_init', 'theme_slug_widgets_init' );
function theme_slug_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Left Sidebar', 'flipmart' ),
        'id' => 'left_sidebar',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'flipmart' ),
        'before_widget' => '<div class="sidebar-widget wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="section-title">',
		'after_title'   => '</h3>',
    ) );
}
