<?php

/*
Widget Name: DB Footer Links Widget
Description: Displays a list of links on footer section.
Author: skyvn
Author URI: http://digibeaver.com/
*/

class DB_Widget_Footer_Links_Widget extends SiteOrigin_Widget {
	function __construct() {
		parent::__construct(
			'db-footer-links-widget',
			__( 'DB Footer Links Widget', 'db' ),
			array(
				'description'   => __( 'Displays a list of links on footer section.', 'db' ),
				'panels_icon'   => 'dashicons dashicons-welcome-widgets-menus',
				'panels_groups' => array( 'db_addonso' )
			),
			array(),
			array(
				'widget_title' => array(
					'type'    => 'text',
					'label'   => __( 'Widget Title', 'db' ),
					'default' => ''
				),
				'links'        => array(
					'type'       => 'repeater',
					'label'      => __( 'Links', 'db' ),
					'item_name'  => __( 'Links', 'db' ),
					'item_label' => array(
						'selector'     => "[id*='features-title']",
						'update_event' => 'change',
						'value_method' => 'val'
					),
					'fields'     => array(
						'title'    => array(
							'type'  => 'text',
							'label' => __( 'Title text', 'db' ),
						),
						'more_url' => array(
							'type'  => 'link',
							'label' => __( 'More link URL', 'db' ),
						),
					),
				)
			),
			dirname( __FILE__ ) . '/'
		);
	}

	function initialize() {
		$this->register_frontend_styles(
			array(
				array(
					'db-footer-links-widget',
					plugin_dir_url( __FILE__ ) . 'css/style.css',
					array('db-common-style'),
					SOW_BUNDLE_VERSION
				)
			)
		);
	}

	function get_style_name( $instance ) {
		return 'footer-links-style';
	}

	function get_template_name( $instance ) {
		return 'footer-links-template';
	}

}

siteorigin_widget_register( 'db-footer-links-widget', __FILE__, 'DB_Widget_Footer_Links_Widget' );