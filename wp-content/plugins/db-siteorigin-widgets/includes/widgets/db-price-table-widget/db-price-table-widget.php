<?php

/*
Widget Name: DB Price Table
Description: A powerful yet simple price table widget for your sidebars or Page Builder pages.
Author: skyvn
Author URI: https://digibeaver.com
*/

class DBOW_PriceTable_Widget extends SiteOrigin_Widget {
	function __construct() {
		parent::__construct(
			'db-price-table',
			__( 'DB Price Table', 'db-so-widgets' ),
			array(
				'description' => __( 'A simple Price Table.', 'db-so-widgets' )
			),
			array(),
			array(
				'title' => array(
					'type'  => 'text',
					'label' => __( 'Title', 'db-so-widgets' ),
				),

				'columns' => array(
					'type'       => 'repeater',
					'label'      => __( 'Columns', 'db-so-widgets' ),
					'item_name'  => __( 'Column', 'db-so-widgets' ),
					'item_label' => array(
						'selector'     => "[id*='columns-title']",
						'update_event' => 'change',
						'value_method' => 'val'
					),
					'fields'     => array(
						'featured' => array(
							'type'  => 'checkbox',
							'label' => __( 'Featured', 'db-so-widgets' ),
						),
						'title'    => array(
							'type'  => 'text',
							'label' => __( 'Title', 'db-so-widgets' ),
						),
						'subtitle' => array(
							'type'  => 'text',
							'label' => __( 'Subtitle', 'db-so-widgets' ),
						),

						'image' => array(
							'type'  => 'media',
							'label' => __( 'Image', 'db-so-widgets' ),
						),

						'price'    => array(
							'type'  => 'text',
							'label' => __( 'Price', 'db-so-widgets' ),
						),
						'per'      => array(
							'type'  => 'text',
							'label' => __( 'Per', 'db-so-widgets' ),
						),
						'button'   => array(
							'type'  => 'text',
							'label' => __( 'Button text', 'db-so-widgets' ),
						),
						'url'      => array(
							'type'  => 'link',
							'label' => __( 'Button URL', 'db-so-widgets' ),
						),
						'features' => array(
							'type'       => 'repeater',
							'label'      => __( 'Features', 'db-so-widgets' ),
							'item_name'  => __( 'Feature', 'db-so-widgets' ),
							'item_label' => array(
								'selector'     => "[id*='columns-features-text']",
								'update_event' => 'change',
								'value_method' => 'val'
							),
							'fields'     => array(
								'text'       => array(
									'type'  => 'text',
									'label' => __( 'Text', 'db-so-widgets' ),
								),
								'hover'      => array(
									'type'  => 'text',
									'label' => __( 'Hover text', 'db-so-widgets' ),
								),
								'icon_new'   => array(
									'type'  => 'icon',
									'label' => __( 'Icon', 'db-so-widgets' ),
								),
								'icon_color' => array(
									'type'  => 'color',
									'label' => __( 'Icon color', 'db-so-widgets' ),
								),
							),
						),
					),
				),

				'theme' => array(
					'type'    => 'select',
					'label'   => __( 'Price table theme', 'db-so-widgets' ),
					'options' => array(
						'atom' => __( 'Atom', 'db-so-widgets' ),
					),
				),

				'header_color' => array(
					'type'  => 'color',
					'label' => __( 'Header color', 'db-so-widgets' ),
				),

				'featured_header_color' => array(
					'type'  => 'color',
					'label' => __( 'Featured header color', 'db-so-widgets' ),
				),

				'button_color' => array(
					'type'  => 'color',
					'label' => __( 'Button color', 'db-so-widgets' ),
				),

				'featured_button_color' => array(
					'type'  => 'color',
					'label' => __( 'Featured button color', 'db-so-widgets' ),
				),

				'button_new_window' => array(
					'type'  => 'checkbox',
					'label' => __( 'Open Button URL in a new window', 'db-so-widgets' ),
				),
			)
		);
	}

	function initialize() {
		$this->register_frontend_scripts(
			array(
				array(
					'db-pricetable',
					plugin_dir_url( __FILE__ ) . 'js/pricetable' . SOW_BUNDLE_JS_SUFFIX . '.js',
					array( 'jquery' )
				)
			)
		);
		$this->register_frontend_styles( array(
			array(
				'db-pricetable',
				plugin_dir_url( __FILE__ ) . 'css/style.css'
			)
		) );
	}

	function get_column_classes( $column, $i, $columns ) {
		$classes = array();
		if ( $i == 0 ) {
			$classes[] = 'db-pt-first';
		}
		if ( $i == count( $columns ) - 1 ) {
			$classes[] = 'db-pt-last';
		}
		if ( ! empty( $column['featured'] ) ) {
			$classes[] = 'db-pt-featured';
		}

		if ( $i % 2 == 0 ) {
			$classes[] = 'db-pt-even';
		} else {
			$classes[] = 'db-pt-odd';
		}

		return implode( ' ', $classes );
	}

	function column_image( $image ) {
		$src = wp_get_attachment_image_src( $image, 'full' );
		?><img src="<?php echo $src[0] ?>" /> <?php
	}

	function get_template_name( $instance ) {
		return $this->get_style_name( $instance );
	}

	function get_style_name( $instance ) {
		if ( empty( $instance['theme'] ) ) {
			return 'atom';
		}

		return $instance['theme'];
	}

	/**
	 * Get the LESS variables for the price table widget.
	 *
	 * @param $instance
	 *
	 * @return array
	 */
	function get_less_variables( $instance ) {
		$instance = wp_parse_args( $instance, array(
			'header_color'          => '',
			'featured_header_color' => '',
			'button_color'          => '',
			'featured_button_color' => '',
		) );

		$colors = array(
			'header_color'          => $instance['header_color'],
			'featured_header_color' => $instance['featured_header_color'],
			'button_color'          => $instance['button_color'],
			'featured_button_color' => $instance['featured_button_color'],
		);

		if ( ! class_exists( 'SiteOrigin_Widgets_Color_Object' ) ) {
			require plugin_dir_path( SOW_BUNDLE_BASE_FILE ) . 'base/inc/color.php';
		}

		if ( ! empty( $instance['button_color'] ) ) {
			$color = new SiteOrigin_Widgets_Color_Object( $instance['button_color'] );
			$color->lum += ( $color->lum > 0.75 ? - 0.5 : 0.8 );
			$colors['button_text_color'] = $color->hex;
		}

		if ( ! empty( $instance['featured_button_color'] ) ) {
			$color = new SiteOrigin_Widgets_Color_Object( $instance['featured_button_color'] );
			$color->lum += ( $color->lum > 0.75 ? - 0.5 : 0.8 );
			$colors['featured_button_text_color'] = $color->hex;
		}

		return $colors;
	}

	/**
	 * Modify the instance to use the new icon.
	 */
	function modify_instance( $instance ) {
		if ( empty( $instance['columns'] ) || ! is_array( $instance['columns'] ) ) {
			return $instance;
		}

		foreach ( $instance['columns'] as &$column ) {
			if ( empty( $column['features'] ) || ! is_array( $column['features'] ) ) {
				continue;
			}

			foreach ( $column['features'] as &$feature ) {

				if ( empty( $feature['icon_new'] ) && ! empty( $feature['icon'] ) ) {
					$feature['icon_new'] = 'fontawesome-' . $feature['icon'];
				}

			}
		}

		return $instance;
	}
}

siteorigin_widget_register( 'db-price-table', __FILE__, 'DBOW_PriceTable_Widget' );