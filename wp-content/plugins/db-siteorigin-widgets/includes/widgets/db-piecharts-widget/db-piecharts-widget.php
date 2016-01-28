<?php

/*
Widget Name: DB Piecharts
Description: Display one or more piecharts depicting a percentage value in a multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class DBOW_Piechart_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'db-piecharts',
            __('DB Piecharts', 'db-so-widgets'),
            array(
                'description' => __('Display statistics or skills as a percentage piechart.', 'db-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => 'http://portfoliotheme.org/widgets-bundle/piechart-widget-documentation/'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'db-so-widgets'),
                ),

                'piecharts' => array(
                    'type' => 'repeater',
                    'label' => __('Piecharts', 'db-so-widgets'),
                    'item_name' => __('Piechart', 'db-so-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='piecharts-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'stats_title' => array(
                            'type' => 'text',
                            'label' => __('Stats Title', 'db-so-widgets'),
                            'description' => __('The title for the piechart', 'db-so-widgets'),
                        ),

                        'percentage' => array(
                            'type' => 'text',
                            'label' => __('Percentage Value', 'db-so-widgets'),
                            'description' => __('The percentage value for the stats.', 'db-so-widgets'),
                        ),
                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'db-so-widgets'),
                    'fields' => array(

                        'bar_color' => array(
                            'type' => 'color',
                            'label' => __('Bar color', 'db-so-widgets'),
                            'default' => '#fe5000'
                        ),

                        'track_color' => array(
                            'type' => 'color',
                            'label' => __('Track color', 'db-so-widgets'),
                            'default' => '#dddddd'
                        ),

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __( 'Piecharts per row', 'db-so-widgets' ),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 4
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
                    'db-waypoints',
                    DBOW_PLUGIN_URL . 'assets/js/jquery.waypoints' . SOW_BUNDLE_JS_SUFFIX . '.js',
                    array('jquery'),
                    DBOW_VERSION
                ),
                array(
                    'db-stats',
                    DBOW_PLUGIN_URL . 'assets/js/jquery.stats' . SOW_BUNDLE_JS_SUFFIX . '.js',
                    array('jquery'),
                    DBOW_VERSION
                ),
            )
        );


        $this->register_frontend_scripts(
            array(
                array(
                    'db-piecharts',
                    plugin_dir_url(__FILE__) . 'js/piechart' . SOW_BUNDLE_JS_SUFFIX . '.js',
                    array('jquery')
                )
            )
        );

        $this->register_frontend_styles(array(
            array(
                'db-piecharts',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'piecharts' => !empty($instance['piecharts']) ? $instance['piecharts'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('db-piecharts', __FILE__, 'DBOW_Piechart_Widget');