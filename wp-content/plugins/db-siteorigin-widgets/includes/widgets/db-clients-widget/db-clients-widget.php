<?php

/*
Widget Name: DB Clients
Description: Display list of your clients in a multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class DBOW_Client_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'db-clients',
            __('DB Clients', 'db-so-widgets'),
            array(
                'description' => __('Display one or more clients in a multi-column grid.', 'db-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => 'http://portfoliotheme.org/widgets-bundle/odometer-widget-documentation/'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'db-so-widgets'),
                ),

                'clients' => array(
                    'type' => 'repeater',
                    'label' => __('Clients', 'db-so-widgets'),
                    'item_name' => __('Client', 'db-so-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='clients-name']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'name' => array(
                            'type' => 'text',
                            'label' => __('Client Name', 'db-so-widgets'),
                            'description' => __('The name of the client/customer.', 'db-so-widgets'),
                        ),

                        'image' => array(
                            'type' => 'media',
                            'label' => __('Client Logo', 'db-so-widgets'),
                            'library' => 'image',
                            'description' => __('The logo image for the client/customer.', 'db-so-widgets'),
                        ),
                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'db-so-widgets'),
                    'fields' => array(

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __('Columns per row', 'db-so-widgets'),
                            'min' => 1,
                            'max' => 6,
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
            )
        );

        $this->register_frontend_styles(array(
            array(
                'db-clients',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'clients' => !empty($instance['clients']) ? $instance['clients'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('db-clients', __FILE__, 'DBOW_Client_Widget');