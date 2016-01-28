<?php

/*
Widget Name: DB Tabs
Description: This widget Display Tabs.
Author: skyvn
Author URI: http://digibeaver.com/
*/

class DB_Tabs_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'db-tabs-widget',
			__( 'DB Tabs Widget', 'db' ),
			array(
				'description'   => __( 'A Tabs widget.', 'db' ),
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
				'repeater'     => array(
					'type'       => 'repeater',
					'label'      => __( 'Tabs', 'db' ),
					'item_name'  => __( 'Tab', 'db' ),
					'item_label' => array(
						'selector'     => "[id*='repeat_text']",
						'update_event' => 'change',
						'value_method' => 'val'
					),
					'fields'     => array(
						'repeat_text'     => array(
							'type'  => 'text',
							'label' => __( 'A text field in a repeater item.', 'db' )
						),
						'repeat_checkbox' => array(
							'type'  => 'checkbox',
							'label' => __( 'A checkbox in a repeater item.', 'db' )
						)
					)
				)
			),
			plugin_dir_path( __FILE__ )
		);
	}

	function get_template_name( $instance ) {
		return 'tabs-base';
	}

	function get_style_name( $instance ) {
		return 'tabs-style';
	}

}

siteorigin_widget_register( 'db-tabs-widget', __FILE__, 'DB_Tabs_Widget' );