<?php

/*
Widget Name: DB FAQs
Description: This widget Display Faq.
Author: skyvn
Author URI: http://digibeaver.com/
*/

class DBOW_Faqs_Widget extends SiteOrigin_Widget {
	function __construct() {

		parent::__construct(
			'db-faqs',
			__( 'DB Faqs', 'db-so-widgets' ),
			array(
				'description' => __( 'FAQs components', 'db-so-widgets' ),
				'panels_icon' => 'dashicons dashicons-minus',
			),
			array(),
			array(
				'widget_title' => array(
					'type'    => 'text',
					'label'   => __( 'Widget Title.', 'db-so-widgets' ),
					'default' => ''
				),

				'posts' => array(
					'type'  => 'posts',
					'label' => __( 'Select FAQs', 'db-so-widgets' ),
				),

				'faqs_styling' => array(
					'type'   => 'section',
					'label'  => __( 'Widget styling', 'db-so-widgets' ),
					'hide'   => true,
					'fields' => array(

						'title_color' => array(
							'type'    => 'color',
							'label'   => __( 'Title color', 'db-so-widgets' ),
							'default' => ''
						),

						'title_hover_color' => array(
							'type'    => 'color',
							'label'   => __( 'Title Hover color', 'db-so-widgets' ),
							'default' => ''
						),

						'content_color' => array(
							'type'    => 'color',
							'label'   => __( 'Content color', 'db-so-widgets' ),
							'default' => ''
						),


					)
				),
				'settings'     => array(
					'type'   => 'section',
					'label'  => __( 'Settings', 'db-so-widgets' ),
					'fields' => array(
						'per_line' => array(
							'type'    => 'slider',
							'label'   => __( 'FAQ Columns per row', 'db-so-widgets' ),
							'min'     => 1,
							'max'     => 4,
							'integer' => true,
							'default' => 2
						),
					)
				)
			)
		);
	}

	function get_template_name( $instance ) {
		return 'faqs-template';
	}

	function get_template_variables( $instance, $args ) {
		return array(
			'settings' => $instance['settings']
		);
	}

	function get_style_name( $instance ) {
		return 'faqs-style';
	}

	function initialize() {

		$this->register_frontend_scripts(
			array(
				array(
					'db-faqs',
					plugin_dir_url( __FILE__ ) . 'js/faqs.js',
					array( 'jquery', 'matchHeight' ),
					DBOW_VERSION,
					true
				),
			)
		);

		$this->register_frontend_styles( array(
			array(
				'db-faqs',
				plugin_dir_url( __FILE__ ) . 'css/style.css'
			)
		) );

	}

	function get_less_variables( $instance ) {
		return array(
			'title_color'       => $instance['faqs_styling']['title_color'],
			'title_hover_color' => $instance['faqs_styling']['title_hover_color'],
			'content_color'     => $instance['faqs_styling']['content_color'],
		);
	}

}


function db_faq() {
	$labels = array(
		'name'               => _x( 'Faqs', 'post type general name' ),
		'singular_name'      => _x( 'Faq', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'Faq' ),
		'add_new_item'       => __( 'Add New Faq' ),
		'edit_item'          => __( 'Edit Faq' ),
		'new_item'           => __( 'New Faq' ),
		'all_items'          => __( 'All Faqs' ),
		'view_item'          => __( 'View Faq' ),
		'search_items'       => __( 'Search Faq' ),
		'not_found'          => __( 'No Faq found' ),
		'not_found_in_trash' => __( 'No Faq found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Faq'
	);
	$args   = array(
		'labels'        => $labels,
		'description'   => 'Holds our products and product specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'has_archive'   => true,
	);
	register_post_type( 'faq', $args );
}

add_action( 'init', 'db_faq' );


siteorigin_widget_register( 'db-faqs', __FILE__, 'DBOW_Faqs_Widget' );