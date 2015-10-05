<?php
/**
 * devotion functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package devotion
 */

if ( ! function_exists( 'devotion_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function devotion_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on devotion, use a find and replace
	 * to change 'devotion' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'devotion', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'devotion' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'devotion_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // devotion_setup
add_action( 'after_setup_theme', 'devotion_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function devotion_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'devotion_content_width', 640 );
}
add_action( 'after_setup_theme', 'devotion_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function devotion_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'devotion' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Site meta left', 'devotion' ),
		'id'            => 'site-meta-left',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Site meta wide', 'devotion' ),
		'id'            => 'site-meta-wide',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'devotion_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function devotion_scripts() {
	wp_enqueue_style( 'devotion-style', get_stylesheet_uri() );

	wp_enqueue_script( 'devotion-script', get_template_directory_uri() . '/js/script.js', array(), '20150927', true );
}
add_action( 'wp_enqueue_scripts', 'devotion_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load WooCommerce compatibility file.
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Remove WooCommerce stylesheet file.
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add custom wrapper to woocommerce product loop
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
  echo '<section id="main spiceflow">';
}
function my_theme_wrapper_end() {
  echo '</section>';
}

/**
 * Remove WooCommerce breadcrumbs.
 */
add_action( 'init', 'jk_remove_wc_breadcrumbs' );
function jk_remove_wc_breadcrumbs() {
  remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

/**
 * Remove page title from WooCommerce pages.
 */
function override_page_title() {
	return false;
}
add_filter('woocommerce_show_page_title', 'override_page_title');

/**
 * Remove Showing results functionality site-wide
 */
function woocommerce_result_count() {
  return false;
}

/**
 * Remove "Sort By" from the Woocommerce Shop Page
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

/**
 * Add overlay shadow element before the end of the shop item loop
 */
function action_woocommerce_after_shop_loop_item_title( $woocommerce_after_shop_loop_item ) {
  echo '<div class="overlay-shadow"></div>';
}
add_action( 'woocommerce_after_shop_loop_item', 'action_woocommerce_after_shop_loop_item_title', 10, 2 );

/**
 * Enqueue Google fonts
 */
function wpb_add_google_fonts() {
	wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Oswald:400,300', false );
}
add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts' );

/**
 * Remove Add to Cart buttons from product loop
 */
function remove_loop_button() {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}
add_action('init','remove_loop_button');

/**
 * Class to extend walker menu
 */
class Menu_With_Description extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth, $args) {
			global $wp_query;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$class_names = $value = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
			$class_names = ' class="' . esc_attr( $class_names ) . '"';

			$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

			$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
			$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
			$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '<span class="menu-description">' . $item->description . '</span>';
			$item_output .= '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

/**
 * Related products configuration
 */
add_filter( 'woocommerce_output_related_products_args', function( $args ) {
  $args = wp_parse_args( array( 'posts_per_page' => 3 ), $args );
  return $args;
});

/**
 * Exclude related products by tag
 */
add_filter( 'woocommerce_product_related_posts_relate_by_tag', function() {
  return false;
});

/**
 * WooCommerce product search override
 */
add_filter( 'get_product_search_form' , 'woo_custom_product_searchform' );
function woo_custom_product_searchform( $form ) {

	$form = '<div class="toggle-search"></div>
	<form role="search" method="get" id="searchform" class="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
		<div>
			<label class="screen-reader-text" for="s">' . __( 'Search for:', 'woocommerce' ) . '</label>
			<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __( 'My Search form', 'woocommerce' ) . '" />
			<input type="submit" id="searchsubmit" value="'. esc_attr__( 'Search', 'woocommerce' ) .'" />
			<input type="hidden" name="post_type" value="product" />
		</div>
	</form>';

	return $form;
}

/**
 * Remove Reviews tab
 */
add_filter( 'woocommerce_product_tabs', 'sb_woo_remove_reviews_tab', 100);
function sb_woo_remove_reviews_tab($tabs) {
	unset($tabs['reviews']);
	return $tabs;
}

/**
 * Wrap product details in common container
 */
add_action( 'woocommerce_before_single_product_summary', 'action_woocommerce_single_product_summary_wrap_start', 30);
add_action( 'woocommerce_after_single_product_summary', 'action_woocommerce_single_product_summary_wrap_end', 12);

function action_woocommerce_single_product_summary_wrap_start() {
  echo '<div class="product-detail-wrap">';
}
function action_woocommerce_single_product_summary_wrap_end() {
  echo '</div>';
}

/**
 * Separate product from related metadata
 */
add_action( 'woocommerce_before_single_product_summary', 'action_woocommerce_single_product_full_wrap_start', 5);
add_action( 'woocommerce_after_single_product_summary', 'action_woocommerce_single_product_full_wrap_end', 13);

function action_woocommerce_single_product_full_wrap_start() {
  echo '<div class="product-full-wrap">';
}
function action_woocommerce_single_product_full_wrap_end() {
  echo '</div>';
}

/**
 * Remove "SKU" from product details page.
 */
add_filter( 'wc_product_sku_enabled', 'mycode_remove_sku_from_product_page' );
function mycode_remove_sku_from_product_page( $boolean ) {
	if ( is_single() ) {
		$boolean = false;
	}
	return $boolean;
}

/**
 * Reorder product detail listing
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_product_main_info_block', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 20 );

function woocommerce_product_main_info_block() {
  echo '<div class="product-main-info">';
	echo the_content();
	echo '</div>';
}

/**
 * Adds Catalog_Ordering_Value widget.
 */
class Catalog_Ordering_Value extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'catalog_ordering_value', // Base ID
			__( 'Woocommerce Catalog Ordering Value', 'text_domain' ), // Name
			array( 'description' => __( 'User selectable products per page', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		/**
		 * User selectable products per page
		 */
		?>
			<form class="woocommerce-ordering" action="" method="POST" name="results">
			<select name="woocommerce-sortby-columns" id="woocommerce-sortby-columns" class="woocommerce-sortby" onchange="this.form.submit()">
		<?php
			$shopCatalog_orderby = apply_filters('woocommerce_sortby_page', array(
				'24' 	=> __('24', 'woocommerce'),
				'64' 		=> __('64', 'woocommerce'),
				'128' 		=> __('128', 'woocommerce'),
			));

			foreach ( $shopCatalog_orderby as $sort_id => $sort_name )
				echo '<option value="' . $sort_id . '" ' . selected( $_SESSION['woocommerce-sortby'], $sort_id, false ) . ' >' . $sort_name . '</option>';
		?>
			</select>
			</form>

		<?php
			if (isset($_POST['woocommerce-sortby-columns']) && (($_COOKIE['wc_sortbyValue'] <> $_POST['woocommerce-sortby-columns']))) {
				$currentProductsPerPage = $_POST['woocommerce-sortby-columns'];
			} else {
				$currentProductsPerPage = $_COOKIE['wc_sortbyValue'];
			}
			?>
		    <script type="text/javascript">
		      jQuery('select.woocommerce-sortby>option[value="<?php echo $currentProductsPerPage; ?>"]').attr('selected', true);
		    </script>
		<?php

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class catalog_ordering_value

/**
 * Register Catalog_Ordering_Value widget.
 */
function register_catalog_ordering_value() {
	register_widget( 'catalog_ordering_value' );
}
add_action( 'widgets_init', 'register_catalog_ordering_value' );

/**
 * Return selected sortby value from cookie to loop
 */
function woocommerce_sortby_value_save( $count ) {
	$main_site_url = home_url( '', relative );
	$cookie_retention_time = ( 14 * 24 * 60 * 60 );

	if (isset($_COOKIE['wc_sortbyValue'])) {
		$count = $_COOKIE['wc_sortbyValue'];
	}
	if (isset($_POST['woocommerce-sortby-columns'])) {
		setcookie('wc_sortbyValue', $_POST['woocommerce-sortby-columns'], time() + $cookie_retention_time, '/', $main_site_url, false);
		$count = $_POST['woocommerce-sortby-columns'];
	}
	return $count;
}
add_filter( 'loop_shop_per_page', 'woocommerce_sortby_value_save' );
