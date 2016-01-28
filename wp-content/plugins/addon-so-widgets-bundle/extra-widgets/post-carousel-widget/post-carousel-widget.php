<?php
/*
Widget Name: DB Post Carousel
Description: Gives you a widget to display your posts as a carousel.
Author: skyvn
Author URI: https://digibeaver.com
*/

/**
 * Add the carousel image sizes
 */
function db_carousel_register_image_sizes() {
	add_image_size( 'sow-carousel-default', 272, 182, true );
}

add_action( 'init', 'db_carousel_register_image_sizes' );

function db_carousel_get_next_posts_page() {
	if ( empty( $_REQUEST['_widgets_nonce'] ) || ! wp_verify_nonce( $_REQUEST['_widgets_nonce'], 'widgets_action' ) ) {
		return;
	}
	$query = wp_parse_args(
		siteorigin_widget_post_selector_process_query( $_GET['query'] ),
		array(
			'post_status'    => 'publish',
			'posts_per_page' => 10,
			'paged'          => empty( $_GET['paged'] ) ? 1 : $_GET['paged']
		)
	);

	$posts = new WP_Query( $query );
	ob_start();
	include 'tpl/carousel-post-loop.php';
	$result = array( 'html' => ob_get_clean() );
	header( 'content-type: application/json' );
	echo json_encode( $result );

	exit();
}

add_action( 'wp_ajax_db_carousel_load', 'db_carousel_get_next_posts_page' );
add_action( 'wp_ajax_nopriv_db_carousel_load', 'db_carousel_get_next_posts_page' );

class DB_Widget_PostCarousel_Widget extends SiteOrigin_Widget {
	function __construct() {
		parent::__construct(
			'db-post-carousel-widget',
			__( 'DB Post Carousel', 'db' ),
			array(
				'description'   => __( 'Display your posts as a carousel.', 'db' ),
				'panels_groups' => array( 'db_addonso' )
			),
			array(),
			array(
				'title' => array(
					'type'  => 'text',
					'label' => __( 'Title', 'db' ),
				),

				'posts' => array(
					'type'  => 'posts',
					'label' => __( 'Posts query', 'db' ),
				),
			),
			dirname( __FILE__ ) . '/'
		);
	}

	function initialize() {
		$this->register_frontend_scripts(
			array(
				array(
					'db-owl-carousel-js',
					plugin_dir_url( __FILE__ ) . 'js/owl-carousel/owl.carousel.min.js',
					array( 'jquery' ),
					'1.6.6'
				),
				array(
					'db-carousel-basic',
					plugin_dir_url( __FILE__ ) . 'js/carousel.js',
					array( 'jquery', 'db-owl-carousel-js', 'imagesloaded' ),
					SOW_BUNDLE_VERSION,
					true
				)
			)
		);
		$this->register_frontend_styles(
			array(
				array(
					'db-owl-carousel',
					plugin_dir_url( __FILE__ ) . 'js/owl-carousel/assets/owl.carousel.min.css',
					array(),
					SOW_BUNDLE_VERSION
				),
				array(
					'db-owl-carousel-theme',
					plugin_dir_url( __FILE__ ) . 'js/owl-carousel/assets/owl.theme.default.min.css',
					array(),
					SOW_BUNDLE_VERSION
				),
				array(
					'db-carousel-basic',
					plugin_dir_url( __FILE__ ) . 'css/style.css',
					array(),
					SOW_BUNDLE_VERSION
				)
			)
		);
	}

	function get_template_name( $instance ) {
		return 'base';
	}

	function get_style_name( $instance ) {
		return false;
	}
}

siteorigin_widget_register( 'db-post-carousel-widget', __FILE__, 'DB_Widget_PostCarousel_Widget' );