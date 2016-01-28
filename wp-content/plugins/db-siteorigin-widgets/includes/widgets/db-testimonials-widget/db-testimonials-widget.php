<?php

/*
Widget Name: DB Testimonials
Description: Display testimonials from your clients/customers in a multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class DBOW_Testimonials_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'db-testimonials',
            __('DB Testimonials', 'db-so-widgets'),
            array(
                'description' => __('Display testimonials in a responsive multi-column grid.', 'db-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => 'http://portfoliotheme.org/widgets-bundle/testimonials-widget-documentation/'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'db-so-widgets'),
                ),
                'testimonials' => array(
                    'type' => 'repeater',
                    'label' => __('Testimonials', 'db-so-widgets'),
                    'item_name' => __('Testimonial', 'db-so-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='testimonials-name']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'name' => array(
                            'type' => 'text',
                            'label' => __('Name', 'db-so-widgets'),
                            'description' => __('The author of the testimonial', 'db-so-widgets'),
                        ),

                        'credentials' => array(
                            'type' => 'text',
                            'label' => __('Author Details', 'db-so-widgets'),
                            'description' => __('The details of the author like company name, position held, company URL etc. HTML accepted.', 'db-so-widgets'),
                        ),

                        'image' => array(
                            'type' => 'media',
                            'label' => __('Image', 'db-so-widgets'),
                        ),

                        'text' => array(
                            'type' => 'tinymce',
                            'label' => __('Text', 'db-so-widgets'),
                            'description' => __('What your customer had to say', 'db-so-widgets'),
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
                'db-testimonials',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'testimonials' => !empty($instance['testimonials']) ? $instance['testimonials'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('db-testimonials', __FILE__, 'DBOW_Testimonials_Widget');