<?php

/*
Widget Name: DB Services
Description: Capture services in a multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class DBOW_Services_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'db-services',
            __('DB Services', 'db-so-widgets'),
            array(
                'description' => __('Create services to display in a column grid.', 'db-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => 'http://portfoliotheme.org/widgets-bundle/services-widget-documentation/'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'db-so-widgets'),
                ),


                'style' => array(
                    'type' => 'select',
                    'label' => __('Choose Style', 'db-so-widgets'),
                    'state_emitter' => array(
                        'callback' => 'select',
                        'args' => array('style')
                    ),
                    'default' => 'style1',
                    'options' => array(
                        'style1' => __('Style 1', 'db-so-widgets'),
                        'style2' => __('Style 2', 'db-so-widgets'),
                    )
                ),

                'services' => array(
                    'type' => 'repeater',
                    'label' => __('Services', 'db-so-widgets'),
                    'item_name' => __('Service', 'db-so-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='services-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(

                        'title' => array(
                            'type' => 'text',
                            'label' => __('Title', 'db-so-widgets'),
                            'description' => __('Title of the service.', 'db-so-widgets'),
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
                            'label' => __('Service Image.', 'db-so-widgets'),
                            'state_handler' => array(
                                'icon_type[icon_image]' => array('show'),
                                'icon_type[icon]' => array('hide'),
                            ),
                        ),

                        'icon' => array(
                            'type' => 'icon',
                            'label' => __('Service Icon.', 'db-so-widgets'),
                            'state_handler' => array(
                                'icon_type[icon]' => array('show'),
                                'icon_type[icon_image]' => array('hide'),
                            ),
                        ),

                        'excerpt' => array(
                            'type' => 'textarea',
                            'label' => __('Short description', 'db-so-widgets'),
                            'description' => __('Provide a short description for the service', 'db-so-widgets'),
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
                            'max' => 5,
                            'integer' => true,
                            'default' => 3
                        ),
                    )
                ),
            )
        );
    }

    function initialize() {


        $this->register_frontend_styles(array(
            array(
                'db-services',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'style' => $instance['style'],
            'services' => !empty($instance['services']) ? $instance['services'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('db-services', __FILE__, 'DBOW_Services_Widget');