<?php

/*
Widget Name: DB Heading
Description: Create heading for display on the top of a section.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class DBOW_Heading_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'db-heading',
            __('DB Heading', 'db-so-widgets'),
            array(
                'description' => __('Create heading for display on the top of a section.', 'db-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => 'http://portfoliotheme.org/widgets-bundle/heading-widget-documentation/'
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

                'heading' => array(
                    'type' => 'text',
                    'label' => __('Heading Title', 'db-so-widgets'),
                    'description' => __('Title for the heading.', 'db-so-widgets'),
                ),

                'subtitle' => array(
                    'type' => 'text',
                    'label' => __('Subheading', 'db-so-widgets'),
                    'description' => __('A subtitle displayed above the title heading.', 'db-so-widgets'),
                    'state_handler' => array(
                        'style[style2]' => array('show'),
                        'style[style1]' => array('hide'),
                    ),
                ),

                'short_text' => array(
                    'type' => 'textarea',
                    'label' => __('Short Text', 'db-so-widgets'),
                    'description' => __('Short text generally displayed below the heading title.', 'db-so-widgets'),
                ),

            )
        );
    }

    function initialize() {

        $this->register_frontend_styles(array(
            array(
                'db-heading',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'style' => $instance['style'],
            'heading' => $instance['heading'],
            'short_text' => !empty($instance['short_text']) ? $instance['short_text'] : '',
            'subtitle' => !empty($instance['subtitle']) ? $instance['subtitle'] : ''
        );
    }

}

siteorigin_widget_register('db-heading', __FILE__, 'DBOW_Heading_Widget');