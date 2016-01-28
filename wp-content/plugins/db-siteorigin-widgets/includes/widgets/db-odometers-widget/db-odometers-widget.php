<?php

/*
Widget Name: DB Odometers
Description: Display one or more animated odometer statistics in a multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class DBOW_Odometer_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'db-odometers',
            __('DB Odometers', 'db-so-widgets'),
            array(
                'description' => __('Display statistics as animated odometers in a multi-column grid.', 'db-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => 'http://portfoliotheme.org/widgets-bundle/odometer-widget-documentation/'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'db-so-widgets'),
                ),

                'odometers' => array(
                    'type' => 'repeater',
                    'label' => __('Odometers', 'db-so-widgets'),
                    'item_name' => __('Odometer', 'db-so-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='odometers-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'stats_title' => array(
                            'type' => 'text',
                            'label' => __('Stats Title', 'db-so-widgets'),
                            'description' => __('The title for the odometer stats', 'db-so-widgets'),
                        ),

                        'start_value' => array(
                            'type' => 'number',
                            'label' => __('Start Value', 'db-so-widgets'),
                            'description' => __('The start value for the odometer stats.', 'db-so-widgets'),
                        ),

                        'stop_value' => array(
                            'type' => 'number',
                            'label' => __('Stop Value', 'db-so-widgets'),
                            'description' => __('The stop value for the odometer stats.', 'db-so-widgets'),
                        ),

                        'icon_type' => array(
                            'type' => 'select',
                            'label' => __('Choose Icon Type', 'db-so-widgets'),
                            'default' => 'icon',
                            'state_emitter' => array(
                                'callback' => 'select',
                                'args' => array('icon_type')
                            ),
                            'options' => array(
                                'icon' => __('Icon', 'db-so-widgets'),
                                'icon_image' => __('Icon Image', 'db-so-widgets'),
                            )
                        ),

                        'icon_image' => array(
                            'type' => 'media',
                            'label' => __('Stats Image.', 'db-so-widgets'),
                            'state_handler' => array(
                                'icon_type[icon_image]' => array('show'),
                                'icon_type[icon]' => array('hide'),
                            ),
                        ),

                        'icon' => array(
                            'type' => 'icon',
                            'label' => __('Stats Icon.', 'db-so-widgets'),
                            'state_handler' => array(
                                'icon_type[icon]' => array('show'),
                                'icon_type[icon_image]' => array('hide'),
                            ),
                        ),

                        'prefix' => array(
                            'type' => 'text',
                            'label' => __('Prefix', 'db-so-widgets'),
                            'description' => __('The prefix string for the odometer stats. Examples include currency symbols like $ to indicate a monetary value.', 'db-so-widgets'),
                        ),

                        'suffix' => array(
                            'type' => 'text',
                            'label' => __('Suffix', 'db-so-widgets'),
                            'description' => __('The suffix string for the odometer stats. Examples include strings like hr for hours or m for million.', 'db-so-widgets'),
                        ),
                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'db-so-widgets'),
                    'fields' => array(

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __('Odometers per row', 'db-so-widgets'),
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
                    'db-odometers',
                    plugin_dir_url(__FILE__) . 'js/odometer' . SOW_BUNDLE_JS_SUFFIX . '.js',
                    array('jquery')
                )
            )
        );

        $this->register_frontend_styles(array(
            array(
                'db-odometers',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'odometers' => !empty($instance['odometers']) ? $instance['odometers'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('db-odometers', __FILE__, 'DBOW_Odometer_Widget');