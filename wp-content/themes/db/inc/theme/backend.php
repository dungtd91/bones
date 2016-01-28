<?php

class DbBackend {

	var $templateURL;

	function __construct() {

		$this->templateURL = get_bloginfo( 'template_url' );

		$this->acf_add_options_page();

		// actions
		add_action( 'tgmpa_register', array( &$this, 'db_register_required_plugins' ) );
		add_action( 'pre_get_posts', array(&$this, 'pre_get_posts_in_homepage') );
		add_action( 'widgets_init', array($this, 'widgets_init'));

		// filters
		add_filter( 'jetpack_development_mode', '__return_true' );
		add_filter( 'single_template', array(&$this, 'get_custom_cat_template'));

		// customizer TinyMCE
		add_filter( 'mce_buttons_2', array( &$this, 'db_mce_buttons' ) );
		add_action( 'init', array( &$this, 'db_add_google_webfonts_to_editor' ) );
		add_filter( 'tiny_mce_before_init', array( &$this, 'db_custom_font_list' ) );
	}

	function acf_add_options_page() {

		if ( function_exists( 'acf_add_options_page' ) ) {

			acf_add_options_page( array(
				'menu_title' => 'Theme Options',
				'menu_slug'  => 'theme-general-settings',
				'capability' => 'edit_posts',
				'icon_url'   => 'dashicons-welcome-write-blog',
				'redirect'   => true
			) );

			acf_add_options_sub_page( array(
				'page_title'  => 'General Settings',
				'menu_title'  => 'General Settings',
				'parent_slug' => 'theme-general-settings',
			) );

			acf_add_options_sub_page( array(
				'page_title'  => 'Home Settings',
				'menu_title'  => 'Home Settings',
				'parent_slug' => 'theme-general-settings',
			) );

		}
	}

	function acf_load_goole_fonts( $field ) {

		$fonts = get_field( 'db_fonts', 'options' );

		$field['choices'] = array();

		if ( have_rows( 'db_fonts', 'option' ) ) {
			while ( have_rows( 'db_fonts', 'option' ) ) {
				the_row();
				$font                       = get_sub_field( 'db_font' );
				$value                      = $font['font'];
				$field['choices'][ $value ] = $value;
			}
		}

		return $field;
	}

	function db_register_required_plugins() {
		$plugins = array(
			array(
				'name'               => 'Page Builder',
				'slug'               => 'siteorigin-panels',
				'source'             => get_stylesheet_directory() . '/extensions/siteorigin-panels.zip',
				'required'           => true,
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
				'is_callable'        => '',
			),
			array(
				'name'               => 'Widgets Bundle',
				'slug'               => 'so-widgets-bundle',
				'source'             => get_stylesheet_directory() . '/extensions/so-widgets-bundle.zip',
				'required'           => true,
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
				'is_callable'        => '',
			)

		);

		$config = array(
			'id'           => 'tgmpa',
			'default_path' => '',
			'menu'         => 'tgmpa-install-plugins',
			'parent_slug'  => 'themes.php',
			'capability'   => 'edit_theme_options',
			'has_notices'  => true,
			'dismissable'  => true,
			'dismiss_msg'  => '',
			'is_automatic' => false,
			'message'      => '',
		);

		tgmpa( $plugins, $config );
	}

	/*
	 * Customize TinyMCE
	 */

	function db_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'fontselect' ); // Add Font Select
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		return $buttons;
	}

	function db_add_google_webfonts_to_editor() {
		$google_selected_fonts_list = array(
			'Open+Sans',
			'Josefin+Slab',
			'Arvo',
			'Lato',
			'Vollkorn',
			'Ubuntu',
			'Old+Standard+TT',
			'Droid+Sans',
			'Roboto',
			'Oswald',
			'Source+Sans+Pro'
		);
		foreach ( $google_selected_fonts_list as $font ) {
			$font_url = 'http://fonts.googleapis.com/css?family=' . $font . ':300,400,,500,600,700';
			add_editor_style( str_replace( ',', '%2C', $font_url ) );
		}
	}

	function db_custom_font_list( $in ) {
		$in['font_formats'] = 'Open Sans=Open Sans; Josefin=Josefin; Slab=Slab; Arvo=Arvo; Lato=Lato; Vollkorn=Vollkorn; Ubuntu=Ubuntu; Old Standard TT=Old Standard TT; Droid Sans=Droid Sans; Roboto=Roboto; Oswald=Oswald; Source Sans Pro=Source Sans Pro';

		$in['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 17px 18px 21px 24px 28px 32px 36px 48px 72px";

		return $in;
	}

	function pre_get_posts_in_homepage( $query ) {
		if ( $query->is_home() && $query->is_main_query() ) {
			$query->set( 'cat', '4' );
		}
	}

	function widgets_init() {
		register_widget( 'DB_Recent_Posts_Widget_Pro' );
		register_widget( 'DB_Related_Posts_Widget_Pro' );
	}

	function get_custom_cat_template( $single_template ) {
		// category Phan-cung
		$parent     = '3';
		$categories = get_categories( 'child_of=' . $parent );
		$cat_names  = wp_list_pluck( $categories, 'name' );

		if ( has_category( 'movies' ) || has_category( $cat_names ) ) {
			$single_template = get_template_directory() . '/single-phan-cung.php';
		}

		return $single_template;

	}

}