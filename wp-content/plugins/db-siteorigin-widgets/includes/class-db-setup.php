<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('DBOW_Setup')):

    class DBOW_Setup {

        public function __construct() {

            add_filter('siteorigin_widgets_widget_folders', array($this, 'add_widgets_collection'));
            add_filter('siteorigin_widgets_field_class_prefixes', array($this, 'custom_fields_class_prefixes'));
            add_filter('siteorigin_widgets_field_class_paths', array($this, 'custom_fields_class_paths'));

            add_filter('siteorigin_panels_widget_dialog_tabs', array($this, 'add_widget_tabs'), 20);

            add_filter('siteorigin_panels_widgets', array($this, 'add_bundle_groups'), 11);


            add_filter('siteorigin_panels_row_style_fields', array($this, 'row_style_fields'));
            add_filter( 'siteorigin_panels_widget_style_fields', array($this, 'widget_style_fields'));


            add_filter('siteorigin_panels_row_style_attributes', array($this, 'row_style_attributes'), 10, 2);
            add_filter('siteorigin_panels_widget_style_attributes', array($this, 'widget_style_attributes'), 10, 2);

            // Main filter to add any custom CSS.
            add_filter('siteorigin_panels_css_object', array($this, 'filter_css_object'), 10, 3);


        }

        function row_style_fields($fields) {

            $fields['top_padding'] = array(
                'name' => __('Top Padding', 'db-so-widgets'),
                'type' => 'measurement',
                'group' => 'layout',
                'description' => __('Top Padding for the row.', 'db-so-widgets'),
                'priority' => 11,
                'multiple' => true
            );

            $fields['bottom_padding'] = array(
                'name' => __('Bottom Padding', 'db-so-widgets'),
                'type' => 'measurement',
                'group' => 'layout',
                'description' => __('Bottom Padding for the row.', 'db-so-widgets'),
                'priority' => 12,
                'multiple' => true
            );

            $fields['tablet_top_padding'] = array(
                'name' => __('Top Padding in Tablet resolution', 'db-so-widgets'),
                'type' => 'measurement',
                'group' => 'layout',
                'description' => __('Top Padding for the row in tablet resolutions.', 'db-so-widgets'),
                'priority' => 13,
                'multiple' => true
            );

            $fields['tablet_bottom_padding'] = array(
                'name' => __('Bottom Padding in Tablet resolution', 'db-so-widgets'),
                'type' => 'measurement',
                'group' => 'layout',
                'description' => __('Bottom Padding for the row in tablet resolutions.', 'db-so-widgets'),
                'priority' => 14,
                'multiple' => true
            );

            $fields['mobile_top_padding'] = array(
                'name' => __('Top Padding in Mobile resolution', 'db-so-widgets'),
                'type' => 'measurement',
                'group' => 'layout',
                'description' => __('Top Padding for the row in mobile resolutions.', 'db-so-widgets'),
                'priority' => 15,
                'multiple' => true
            );

            $fields['mobile_bottom_padding'] = array(
                'name' => __('Bottom Padding in Mobile resolution', 'db-so-widgets'),
                'type' => 'measurement',
                'group' => 'layout',
                'description' => __('Bottom Padding for the row in mobile resolutions.', 'db-so-widgets'),
                'priority' => 16,
                'multiple' => true
            );

            /* Add design fields */

            $fields['db_dark_bg'] = array(
                'name' => __('Dark Background?', 'db-so-widgets'),
                'type' => 'checkbox',
                'group' => 'design',
                'label' => __('Indicate if this row has a dark background color. Dark color scheme will be applied for all widgets in this row.', 'db-so-widgets'),
                'default' => false,
                'priority' => 4,
            );


            return $fields;
        }

        function row_style_attributes($attributes, $args) {

            if (!empty($args['db_dark_bg']))
            {
                if (empty($attributes['class']))
                    $attributes['class'] = array();

                $attributes['class'][] = 'db-dark-bg';
            }

            return $attributes;
        }

        function filter_css_object($css, $panels_data, $post_id) {

            foreach ($panels_data['grids'] as $gi => $grid) {

                $top_padding = (isset($grid['style']['top_padding']) ? $grid['style']['top_padding'] : null);
                $bottom_padding = (isset($grid['style']['bottom_padding']) ? $grid['style']['bottom_padding'] : null);;

                // Filter the bottom margin for this row with the arguments
                if ($top_padding)
                    $css->add_row_css($post_id, $gi, '.panel-row-style', array('padding-top' => $top_padding), 1920);
                if ($bottom_padding)
                    $css->add_row_css($post_id, $gi, '.panel-row-style', array('padding-bottom' => $bottom_padding), 1920);

                $top_padding = (isset($grid['style']['tablet_top_padding']) ? $grid['style']['tablet_top_padding'] : null);
                $bottom_padding = (isset($grid['style']['tablet_bottom_padding']) ? $grid['style']['tablet_bottom_padding'] : null);;

                // Filter the bottom margin for this row with the arguments
                if ($top_padding)
                    $css->add_row_css($post_id, $gi, '.panel-row-style', array('padding-top' => $top_padding), 960);
                if ($bottom_padding)
                    $css->add_row_css($post_id, $gi, '.panel-row-style', array('padding-bottom' => $bottom_padding), 960);


                $top_padding = (isset($grid['style']['mobile_top_padding']) ? $grid['style']['mobile_top_padding'] : null);
                $bottom_padding = (isset($grid['style']['mobile_bottom_padding']) ? $grid['style']['mobile_bottom_padding'] : null);;

                // Filter the bottom margin for this row with the arguments
                if ($top_padding)
                    $css->add_row_css($post_id, $gi, '.panel-row-style', array('padding-top' => $top_padding), 478);
                if ($bottom_padding)
                    $css->add_row_css($post_id, $gi, '.panel-row-style', array('padding-bottom' => $bottom_padding), 478);


            }
            return $css;
        }

        function widget_style_fields($fields) {
            $fields['padding_top']    = array(
                'name'        => __( 'Padding Top', 'db-so-widgets' ),
                'type'        => 'measurement',
                'group'       => 'layout',
                'description' => __( 'Padding Top Customize around the entire widget.', 'db-so-widgets' ),
                'priority'    => 8,
                'multiple'    => true
            );
            $fields['padding_right']  = array(
                'name'        => __( 'Padding Right', 'db-so-widgets' ),
                'type'        => 'measurement',
                'group'       => 'layout',
                'description' => __( 'Padding Right Customize around the entire widget.', 'db-so-widgets' ),
                'priority'    => 9,
                'multiple'    => true
            );
            $fields['padding_bottom'] = array(
                'name'        => __( 'Padding Bottom', 'db-so-widgets' ),
                'type'        => 'measurement',
                'group'       => 'layout',
                'description' => __( 'Padding Bottom Customize around the entire widget.', 'db-so-widgets' ),
                'priority'    => 10,
                'multiple'    => true
            );
            $fields['padding_left']   = array(
                'name'        => __( 'Padding Left', 'db-so-widgets' ),
                'type'        => 'measurement',
                'group'       => 'layout',
                'description' => __( 'Padding Left Customize around the entire widget.', 'db-so-widgets' ),
                'priority'    => 11,
                'multiple'    => true
            );

            return $fields;
        }

        function widget_style_attributes($attributes, $args) {
            if ( ! empty( $args['padding_top'] ) ) {
                $attributes['style'] .= 'padding-top: ' . esc_attr( $args['padding_top'] ) . ';';
            }
            if ( ! empty( $args['padding_right'] ) ) {
                $attributes['style'] .= 'padding-right: ' . esc_attr( $args['padding_right'] ) . ';';
            }
            if ( ! empty( $args['padding_bottom'] ) ) {
                $attributes['style'] .= 'padding-bottom: ' . esc_attr( $args['padding_bottom'] ) . ';';
            }
            if ( ! empty( $args['padding_left'] ) ) {
                $attributes['style'] .= 'padding-left: ' . esc_attr( $args['padding_left'] ) . ';';
            }

            return $attributes;
        }

        function add_widgets_collection($folders) {
            $folders[] = DBOW_PLUGIN_DIR . 'includes/widgets/';
            return $folders;
        }


        // Placing all widgets under the 'SiteOrigin Widgets' Tab
        function add_widget_tabs($tabs) {
            $tabs[] = array(
                'title' => __('DB SiteOrigin Widgets', 'db-so-widgets'),
                'filter' => array(
                    'groups' => array('db-widgets')
                )
            );
            return $tabs;
        }


        // Adding group for all Widgets
        function add_bundle_groups($widgets) {
            foreach ($widgets as $class => &$widget) {
                if (preg_match('/DBOW_(.*)_Widget/', $class, $matches)) {
                    $widget['groups'] = array('db-widgets');
                }
            }
            return $widgets;
        }


        function custom_fields_class_prefixes($class_prefixes) {
            $class_prefixes[] = 'DBOW_Custom_Field_';
            return $class_prefixes;
        }

        function custom_fields_class_paths($class_paths) {
            $class_paths[] = DBOW_PLUGIN_DIR . 'includes/custom-fields/';
            return $class_paths;
        }

    }

endif;

new DBOW_Setup();
