<?php

/*
Widget Name: DB Stats Bars
Description: Display multiple stats bars that talk about skills or other percentage stats.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class DBOW_Stats_Bars_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'db-stats-bars',
            __('DB Stats Bars', 'db-so-widgets'),
            array(
                'description' => __('Display statistics or skills as a percentage stats bar.', 'db-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => 'http://portfoliotheme.org/widgets-bundle/stats-bar-widget-documentation/'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'db-so-widgets'),
                ),
                'stats-bars' => array(
                    'type' => 'repeater',
                    'label' => __('Stats Bars', 'db-so-widgets'),
                    'item_name' => __('Stats Bar', 'db-so-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='stats-bars-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'label' => __('Stats Title', 'db-so-widgets'),
                            'description' => __('The title for the stats bar', 'db-so-widgets'),
                        ),

                        'value' => array(
                            'type' => 'text',
                            'label' => __('Percentage Value', 'db-so-widgets'),
                            'description' => __('The percentage value for the stats.', 'db-so-widgets'),
                        ),

                        'color' => array(
                            'type' => 'color',
                            'label' => __('Bar color', 'db-so-widgets'),
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
            )
        );


        $this->register_frontend_scripts(
            array(
                array(
                    'db-stats-bar',
                    plugin_dir_url(__FILE__) . 'js/stats-bar' . SOW_BUNDLE_JS_SUFFIX . '.js',
                    array('jquery')
                ),
            )
        );

        $this->register_frontend_styles(array(
            array(
                'db-stats-bar',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'stats_bars' => !empty($instance['stats-bars']) ? $instance['stats-bars'] : array()
        );
    }

}

siteorigin_widget_register('db-stats-bars', __FILE__, 'DBOW_Stats_Bars_Widget');