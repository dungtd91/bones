<?php

/*
Widget Name: DB Quicksand Post Filter
Description: Use the Jquery Quicksand to filter posts by categories.
Author: skyvn
Author URI: https://digibeaver.com
*/

class DB_Widget_QuicksandPostFilter_Widget extends SiteOrigin_Widget {
	function __construct() {
		parent::__construct(
			'db-quicksand-post-filter-widget',
			__( 'DB Quicksand Post Filter', 'db' ),
			array(
				'description'   => __( 'Use the Jquery Quicksand to filter posts by categories.', 'db' ),
				'panels_groups' => array( 'db_addonso' )
			),
			array(),
			array(
				'title'             => array(
					'type'  => 'text',
					'label' => __( 'Title', 'db' ),
				),
				'filter_categories' => array(
					'type'     => 'select',
					'label'    => __( 'Filter Categories', 'db' ),
					'multiple' => true,
					'options'  => $this->get_all_categories()
				)


			),
			dirname( __FILE__ ) . '/'
		);
	}

	function initialize() {
		$this->register_frontend_scripts(
			array(
				array(
					'db-easing-js',
					plugin_dir_url( __FILE__ ) . 'js/jquery.easing.1.3.js',
					array( 'jquery' ),
					'1.6.6'
				),
				array(
					'db-quicksand-js',
					plugin_dir_url( __FILE__ ) . 'js/jquery.quicksand.js',
					array( 'jquery', 'db-easing-js' ),
					'1.6.6'
				),
				array(
					'db-quicksand-filter-main',
					plugin_dir_url( __FILE__ ) . 'js/main.js',
					array( 'jquery', 'db-easing-js', 'db-quicksand-js', 'matchHeight' ),
					SOW_BUNDLE_VERSION,
					true
				)
			)
		);
		$this->register_frontend_styles(
			array(
				array(
					'db-quiksand-post-filter',
					plugin_dir_url( __FILE__ ) . 'css/layout.css',
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

	function get_all_categories() {
		$categories = get_categories();
		$options    = array();
		foreach ( $categories as $category ) {
			$options[$category->term_id] = $category->name;
		}
		return $options;
	}
}

siteorigin_widget_register( 'db-quicksand-post-filter-widget', __FILE__, 'DB_Widget_QuicksandPostFilter_Widget' );