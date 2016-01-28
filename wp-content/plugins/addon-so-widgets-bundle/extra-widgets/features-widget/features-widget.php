<?php

/*
Widget Name: DB Features Widget
Description: Displays a block of features with icons.
Author: skyvn
Author URI: http://digibeaver.com/
*/

class DB_Widget_Features_Widget extends SiteOrigin_Widget {
	function __construct() {
		parent::__construct(
			'db-features-widget',
			__( 'DB Features Widget', 'db' ),
			array(
				'description'   => __( 'Displays a list of features.', 'db' ),
				'panels_icon'   => 'dashicons dashicons-welcome-widgets-menus',
				'panels_groups' => array( 'db_addonso' )
			),
			array(),
			array(
				'widget_title'    => array(
					'type'    => 'text',
					'label'   => __( 'Widget Title', 'db' ),
					'default' => ''
				),
				'features'        => array(
					'type'       => 'repeater',
					'label'      => __( 'Features', 'db' ),
					'item_name'  => __( 'Feature', 'db' ),
					'item_label' => array(
						'selector'     => "[id*='features-title']",
						'update_event' => 'change',
						'value_method' => 'val'
					),
					'fields'     => array(
						'icon_image' => array(
							'type'        => 'media',
							'library'     => 'image',
							'label'       => __( 'Icon image', 'db' ),
							'description' => __( 'Use your own icon image.', 'db' ),
						),

						// The text under the icon

						'title' => array(
							'type'  => 'text',
							'label' => __( 'Title text', 'db' ),
						),

						'text' => array(
							'type'  => 'text',
							'label' => __( 'Text', 'db' )
						),

						'more_url' => array(
							'type'  => 'link',
							'label' => __( 'More link URL', 'db' ),
						),
					),
				),
				'callout_section' => array(
					'type'   => 'section',
					'label'  => __( 'Button call to action.', 'db' ),
					'hide'   => false,
					'fields' => array(
						'cta_text'      => array(
							'type'  => 'text',
							'label' => __( 'Button Text', 'db' )
						),
						'cta_icon'      => array(
							'type'  => 'icon',
							'label' => __( 'Button Icon', 'db' )
						),
						'cta_link'      => array(
							'type'  => 'link',
							'label' => __( 'Link', 'db' )
						),
						'cta_alignment' => array(
							'type'    => 'radio',
							'label'   => __( 'Position alignment', 'db' ),
							'default' => 'left',
							'options' => array(
								'left'      => __( 'Left', 'db' ),
								'right' => __( 'Right', 'db' )
							)
						)
					)
				),
				'fonts'           => array(
					'type'   => 'section',
					'label'  => __( 'Fonts', 'db' ),
					'hide'   => true,
					'fields' => array(
						'title_options' => array(
							'type'   => 'section',
							'label'  => __( 'Title', 'db' ),
							'hide'   => true,
							'fields' => array(
								'font'  => array(
									'type'    => 'font',
									'label'   => __( 'Font', 'db' ),
									'default' => 'default'
								),
								'size'  => array(
									'type'  => 'measurement',
									'label' => __( 'Size', 'db' ),
								),
								'color' => array(
									'type'  => 'color',
									'label' => __( 'Color', 'db' ),
								)
							)
						),

						'text_options' => array(
							'type'   => 'section',
							'label'  => __( 'Text', 'db' ),
							'hide'   => true,
							'fields' => array(
								'font'  => array(
									'type'    => 'font',
									'label'   => __( 'Font', 'db' ),
									'default' => 'default'
								),
								'size'  => array(
									'type'  => 'measurement',
									'label' => __( 'Size', 'db' ),
								),
								'color' => array(
									'type'  => 'color',
									'label' => __( 'Color', 'db' ),
								)
							)
						)

					),
				),

				'per_row' => array(
					'type'    => 'number',
					'label'   => __( 'Features per row', 'db' ),
					'default' => 3,
				),

				'title_link' => array(
					'type'    => 'checkbox',
					'label'   => __( 'Link feature title to more URL', 'db' ),
					'default' => false,
				),

				'icon_link' => array(
					'type'    => 'checkbox',
					'label'   => __( 'Link icon to more URL', 'db' ),
					'default' => false,
				),

				'new_window' => array(
					'type'    => 'checkbox',
					'label'   => __( 'Open more URL in a new window', 'db' ),
					'default' => false,
				),


			),
			dirname( __FILE__ ) . '/'
		);
	}

	function initialize() {
		$this->register_frontend_styles(
			array(
				array(
					'db-features-widget',
					plugin_dir_url( __FILE__ ) . 'css/style.css',
					array( 'db-common-style' ),
					SOW_BUNDLE_VERSION
				)
			)
		);
	}

	function get_style_name( $instance ) {
		return 'features-style';
	}

	function get_less_variables( $instance ) {
		$less_vars = array();

		$fonts                 = $instance['fonts'];
		$styleable_text_fields = array( 'title', 'text', 'more_text' );

		foreach ( $styleable_text_fields as $field_name ) {

			if ( ! empty( $fonts[ $field_name . '_options' ] ) ) {
				$styles = $fonts[ $field_name . '_options' ];
				if ( ! empty( $styles['size'] ) ) {
					$less_vars[ $field_name . '_size' ] = $styles['size'];
				}
				if ( ! empty( $styles['color'] ) ) {
					$less_vars[ $field_name . '_color' ] = $styles['color'];
				}
				if ( ! empty( $styles['font'] ) ) {
					$font                               = siteorigin_widget_get_font( $styles['font'] );
					$less_vars[ $field_name . '_font' ] = $font['family'];
					if ( ! empty( $font['weight'] ) ) {
						$less_vars[ $field_name . '_font_weight' ] = $font['weight'];
					}
				}
			}
		}

		return $less_vars;
	}

	function get_google_font_fields( $instance ) {

		$fonts = $instance['fonts'];

		return array(
			$fonts['title_options']['font'],
			$fonts['text_options']['font'],
			$fonts['more_text_options']['font'],
		);
	}

	function get_template_name( $instance ) {
		return 'features-base';
	}

}

siteorigin_widget_register( 'db-features-widget', __FILE__, 'DB_Widget_Features_Widget' );