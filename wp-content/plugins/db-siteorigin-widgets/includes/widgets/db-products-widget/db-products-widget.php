<?php

/*
Widget Name: DB Products
Description: Display product items from category Products.
Author: skyvn
Author URI: http://digibeaver.com
*/

class DBOW_Products_Widget extends SiteOrigin_Widget {

	function __construct() {
		parent::__construct(
			'db-products',
			__( 'DB Products', 'db-so-widgets' ),
			array(
				'description' => __( 'Display product items from category Products.', 'db-so-widgets' ),
				'panels_icon' => 'dashicons dashicons-minus',
			),
			array(),
			array(
				'widget_title'    => array(
					'type'  => 'text',
					'label' => __( 'Title', 'db-so-widgets' ),
				),
				'products' => array(
					'type'  => 'posts',
					'label' => __( 'Posts query', 'db-so-widgets' ),
				),
				'settings' => array(
					'type'   => 'section',
					'label'  => __( 'Settings', 'db-so-widgets' ),
					'fields' => array(
						'background_image_color'   => array(
							'type'    => 'color',
							'label'   => __( 'Background Image Color', 'db-so-widgets' ),
							'default' => '#f5f5f5'
						),
						'background_caption_color' => array(
							'type'    => 'color',
							'label'   => __( 'Background Caption Color', 'db-so-widgets' ),
							'default' => '#1B85BD'
						),
						'text_color'               => array(
							'type'    => 'color',
							'label'   => __( 'Text Color', 'db-so-widgets' ),
							'default' => '#ffffff'
						),
						'per_line'                 => array(
							'type'    => 'slider',
							'label'   => __( 'Columns per row', 'db-so-widgets' ),
							'min'     => 1,
							'max'     => 4,
							'integer' => true,
							'default' => 3
						),
					)
				),
			)
		);
	}

	function initialize() {

		$this->register_frontend_scripts(
			array(
				array(
					'db-products-widget',
					plugin_dir_url( __FILE__ ) . 'js/products.js',
					array( 'jquery', 'matchHeight' ),
					DBOW_VERSION
				),
			)
		);

		$this->register_frontend_styles( array(
				array(
					'db-products-widget',
					plugin_dir_url( __FILE__ ) . 'css/style.css'
				)
			)
		);

	}


	function get_less_variables( $instance ) {
		return array(
			'bg_caption' => $instance['settings']['background_caption_color'],
			'bg_image'   => $instance['settings']['background_image_color'],
			'text_color' => $instance['settings']['text_color']
		);
	}

	function get_template_variables( $instance, $args ) {
		return array(
			'products' => $instance['products'],
			'settings' => $instance['settings']
		);
	}

}

siteorigin_widget_register( 'db-products', __FILE__, 'DBOW_Products_Widget' );