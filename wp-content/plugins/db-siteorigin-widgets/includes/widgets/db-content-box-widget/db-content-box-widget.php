<?php

/*
Widget Name: DB Content Box Widget
Description: Capture content box in a multi-column grid.
Author: skyvn
Author URI: http://digibeaver.com
*/

class DBOW_Content_Box_Widget extends SiteOrigin_Widget {

	function __construct() {
		parent::__construct(
			'db-content-box',
			__( 'DB Content Box', 'db-so-widgets' ),
			array(
				'description' => __( 'Capture content box in a multi-column grid.', 'db-so-widgets' ),
				'panels_icon' => 'dashicons dashicons-minus',
			),
			array(),
			array(
				'title'    => array(
					'type'  => 'text',
					'label' => __( 'Title', 'db-so-widgets' ),
				),
				'contents' => array(
					'type'       => 'repeater',
					'label'      => __( 'Content Boxs', 'db-so-widgets' ),
					'item_name'  => __( 'Box', 'db-so-widgets' ),
					'item_label' => array(
						'selector'     => "[id*='contents-title']",
						'update_event' => 'change',
						'value_method' => 'val'
					),
					'fields'     => array(
						'title'      => array(
							'type'        => 'text',
							'label'       => __( 'Title', 'db-so-widgets' ),
							'description' => __( 'Title of the service.', 'db-so-widgets' ),
						),
						'content'    => array(
							'type'        => 'tinymce',
							'rows'        => 10,
							'label'       => __( 'Short description', 'db-so-widgets' ),
							'description' => __( 'Provide a short description for the content', 'db-so-widgets' ),
						),
						'box_styles' => array(
							'type'   => 'section',
							'label'  => __( 'Section color box.', 'db-so-widgets' ),
							'hide'   => false,
							'fields' => array(
								'border_color'     => array(
									'type'  => 'color',
									'label' => __( 'Box border Color', 'db-so-widgets' )
								),
								'background_color' => array(
									'type'  => 'color',
									'label' => __( 'Box background color', 'db-so-widgets' )
								)
							)
						)
					)
				),

				'settings' => array(
					'type'   => 'section',
					'label'  => __( 'Settings', 'db-so-widgets' ),
					'fields' => array(

						'per_line' => array(
							'type'    => 'slider',
							'label'   => __( 'Columns per row', 'db-so-widgets' ),
							'min'     => 1,
							'max'     => 5,
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
					'db-content-box',
					plugin_dir_url( __FILE__ ) . 'js/content-box.js',
					array( 'jquery', 'matchHeight' ),
					DBOW_VERSION,
					true
				),
			)
		);

		$this->register_frontend_styles( array(
			array(
				'db-content-box',
				plugin_dir_url( __FILE__ ) . 'css/style.css'
			)
		) );
	}

	function get_template_variables( $instance, $args ) {
		return array(
			'contents' => ! empty( $instance['contents'] ) ? $instance['contents'] : array(),
			'settings' => $instance['settings']
		);
	}

}

siteorigin_widget_register( 'db-content-box', __FILE__, 'DBOW_Content_Box_Widget' );