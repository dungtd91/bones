<?php

/*
Widget Name: DB Headline
Description: A headline to headline all headlines.
Author: skyvn
Author URI: https://digibeaver.com
*/

class DB_Widget_Headline_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'db-headline-widget',
			__( 'DB Headline', 'db' ),
			array(
				'description'   => __( 'A headline widget.', 'db' ),
				'panels_groups' => array( 'db_addonso' )
			),
			array(),
			array(
				'headline'     => array(
					'type'   => 'section',
					'label'  => __( 'Headline', 'db' ),
					'hide'   => false,
					'fields' => array(
						'text'  => array(
							'type'  => 'text',
							'label' => __( 'Text', 'db' ),
						),
						'tag'   => array(
							'type'    => 'select',
							'label'   => __( 'H Tag', 'db' ),
							'default' => 'h1',
							'options' => array(
								'h1' => __( 'H1', 'db' ),
								'h2' => __( 'H2', 'db' ),
								'h3' => __( 'H3', 'db' ),
								'h4' => __( 'H4', 'db' ),
								'h5' => __( 'H5', 'db' ),
								'h6' => __( 'H6', 'db' ),
							)
						),
						'font'  => array(
							'type'    => 'font',
							'label'   => __( 'Font', 'db' ),
							'default' => 'Roboto'
						),
						'font_size'  => array(
								'type'    => 'measurement',
								'label'   => __( 'Font Size', 'db' ),
								'default' => 'default',
						),
						'color' => array(
							'type'  => 'color',
							'label' => __( 'Color', 'db' ),
						),
						'align' => array(
							'type'    => 'select',
							'label'   => __( 'Align', 'db' ),
							'default' => 'center',
							'options' => array(
								'center'  => __( 'Center', 'db' ),
								'left'    => __( 'Left', 'db' ),
								'right'   => __( 'Right', 'db' ),
								'justify' => __( 'Justify', 'db' )
							)
						)
					)
				),
				'sub_headline' => array(
					'type'   => 'section',
					'label'  => __( 'Sub headline', 'db' ),
					'hide'   => true,
					'fields' => array(
						'text'  => array(
							'type'  => 'text',
							'label' => __( 'Text', 'db' )
						),
						'tag'   => array(
							'type'    => 'select',
							'label'   => __( 'H Tag', 'db' ),
							'default' => 'h3',
							'options' => array(
								'h1' => __( 'H1', 'db' ),
								'h2' => __( 'H2', 'db' ),
								'h3' => __( 'H3', 'db' ),
								'h4' => __( 'H4', 'db' ),
								'h5' => __( 'H5', 'db' ),
								'h6' => __( 'H6', 'db' ),
								'p' => __( 'P', 'db' ),
							)
						),
						'font'  => array(
							'type'    => 'font',
							'label'   => __( 'Font', 'db' ),
							'default' => 'Roboto'
						),
						'font_size'  => array(
							'type'    => 'measurement',
							'label'   => __( 'Font size', 'db' ),
							'default' => 'default',
						),
						'color' => array(
							'type'  => 'color',
							'label' => __( 'Color', 'db' ),
						),
						'align' => array(
							'type'    => 'select',
							'label'   => __( 'Align', 'db' ),
							'default' => 'center',
							'options' => array(
								'center'  => __( 'Center', 'db' ),
								'left'    => __( 'Left', 'db' ),
								'right'   => __( 'Right', 'db' ),
								'justify' => __( 'Justify', 'db' )
							)
						)
					)
				),
				'divider'      => array(
					'type'   => 'section',
					'label'  => __( 'Divider', 'db' ),
					'hide'   => true,
					'fields' => array(
						'style'       => array(
							'type'    => 'select',
							'label'   => __( 'Style', 'db' ),
							'default' => 'solid',
							'options' => array(
								'none'   => __( 'None', 'db' ),
								'solid'  => __( 'Solid', 'db' ),
								'dotted' => __( 'Dotted', 'db' ),
								'dashed' => __( 'Dashed', 'db' ),
								'double' => __( 'Double', 'db' ),
								'groove' => __( 'Groove', 'db' ),
								'ridge'  => __( 'Ridge', 'db' ),
								'inset'  => __( 'Inset', 'db' ),
								'outset' => __( 'Outset', 'db' ),
							)
						),
						'weight'      => array(
							'type'    => 'select',
							'label'   => __( 'Weight', 'db' ),
							'default' => 'thin',
							'options' => array(
								'thin'   => __( 'Thin', 'db' ),
								'medium' => __( 'Medium', 'db' ),
								'thick'  => __( 'Thick', 'db' ),
							)
						),
						'color'       => array(
							'type'    => 'color',
							'label'   => __( 'Color', 'db' ),
							'default' => '#EEEEEE'
						),
						'side_margin' => array(
							'type'    => 'measurement',
							'label'   => __( 'Side Margin', 'db' ),
							'default' => '60px',
						),
						'top_margin'  => array(
							'type'    => 'measurement',
							'label'   => __( 'Top/Bottom Margin', 'db' ),
							'default' => '20px',
						)
					)
				)
			),
			dirname( __FILE__ ) . '/'
		);
	}

	function get_style_name( $instance ) {
		return 'sow-headline';
	}

	function get_less_variables( $instance ) {
		$less_vars = array();

		if ( ! empty( $instance['headline'] ) ) {
			$headline_styles = $instance['headline'];
			if ( ! empty( $headline_styles['tag'] ) ) {
				$less_vars['headline_tag'] = $headline_styles['tag'];
			}
			if ( ! empty( $headline_styles['align'] ) ) {
				$less_vars['headline_align'] = $headline_styles['align'];
			}
			if ( ! empty( $headline_styles['color'] ) ) {
				$less_vars['headline_color'] = $headline_styles['color'];
			}
			if ( ! empty( $headline_styles['font'] ) ) {
				$font                       = siteorigin_widget_get_font( $headline_styles['font'] );
				$less_vars['headline_font'] = $font['family'];
				if ( ! empty( $font['weight'] ) ) {
					$less_vars['headline_font_weight'] = $font['weight'];
				}
			}
			if ( ! empty( $headline_styles['font_size'] ) ) {
				$less_vars['headline_font_size'] = $headline_styles['font_size'];
			}
		}

		if ( ! empty( $instance['sub_headline'] ) ) {
			$sub_headline_styles = $instance['sub_headline'];
			if ( ! empty( $sub_headline_styles['align'] ) ) {
				$less_vars['sub_headline_align'] = $sub_headline_styles['align'];
			}
			if ( ! empty( $sub_headline_styles['tag'] ) ) {
				$less_vars['sub_headline_tag'] = $sub_headline_styles['tag'];
			}
			if ( ! empty( $sub_headline_styles['color'] ) ) {
				$less_vars['sub_headline_color'] = $sub_headline_styles['color'];
			}
			if ( ! empty( $sub_headline_styles['font'] ) ) {
				$font                           = siteorigin_widget_get_font( $sub_headline_styles['font'] );
				$less_vars['sub_headline_font'] = $font['family'];
				if ( ! empty( $font['weight'] ) ) {
					$less_vars['sub_headline_font_weight'] = $font['weight'];
				}
			}
			if ( ! empty( $sub_headline_styles['font_size'] ) ) {
				$less_vars['sub_headline_size'] = $sub_headline_styles['font_size'];
			}
		}

		if ( ! empty( $instance['divider'] ) ) {
			$divider_styles = $instance['divider'];

			if ( ! empty( $divider_styles['style'] ) ) {
				$less_vars['divider_style'] = $divider_styles['style'];
			}

			if ( ! empty( $divider_styles['weight'] ) ) {
				$less_vars['divider_weight'] = $divider_styles['weight'];
			}

			if ( ! empty( $divider_styles['color'] ) ) {
				$less_vars['divider_color'] = $divider_styles['color'];
			}

			if ( ! empty( $divider_styles['top_margin'] ) && ! empty( $divider_styles['top_margin_unit'] ) ) {
				$less_vars['divider_top_margin'] = $divider_styles['top_margin'] . $divider_styles['top_margin_unit'];
			}

			if ( ! empty( $divider_styles['side_margin'] ) && ! empty( $divider_styles['side_margin_unit'] ) ) {
				$less_vars['divider_side_margin'] = $divider_styles['side_margin'] . $divider_styles['side_margin_unit'];
			}


		}

		return $less_vars;
	}

	function get_google_font_fields( $instance ) {

		return array(
			$instance['headline']['font'],
			$instance['sub_headline']['font'],
		);
	}

	/**
	 * Get the template for the headline widget
	 *
	 * @param $instance
	 *
	 * @return mixed|string
	 */
	function get_template_name( $instance ) {
		return 'headline';
	}

	/**
	 * Get the template variables for the headline
	 *
	 * @param $instance
	 * @param $args
	 *
	 * @return array
	 */
	function get_template_variables( $instance, $args ) {
		if ( empty( $instance ) ) {
			return array();
		}

		return array(
			'headline'         => $instance['headline']['text'],
			'headline_tag'     => $instance['headline']['tag'],
			'sub_headline'     => $instance['sub_headline']['text'],
			'sub_headline_tag' => $instance['sub_headline']['tag'],
			'has_divider'      => ! empty( $instance['divider'] ) && $instance['divider']['style'] != 'none'
		);
	}
}

siteorigin_widget_register( 'db-headline-widget', __FILE__, 'DB_Widget_Headline_Widget' );