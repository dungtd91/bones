<?php

/*
Widget Name: DB Testimonials Slider
Description: Display responsive touch friendly slider of testimonials from clients/customers.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class DBOW_Testimonials_Slider_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'db-testimonials-slider',
            __('DB Testimonials Slider', 'db-so-widgets'),
            array(
                'description' => __('Share your product/service testimonials in a responsive slider.', 'db-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => 'http://portfoliotheme.org/widgets-bundle/testimonials-slider-widget-documentation/'
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

                        'slideshow_speed' => array(
                            'type' => 'number',
                            'label' => __('Slideshow speed', 'db-so-widgets'),
                            'default' => 5000
                        ),

                        'animation_speed' => array(
                            'type' => 'number',
                            'label' => __('Animation Speed', 'db-so-widgets'),
                            'default' => 600
                        ),

                        'pause_on_action' => array(
                            'type' => 'checkbox',
                            'label' => __('Pause slider on action.', 'db-so-widgets'),
                            'description' => __('Should the slideshow pause once user initiates an action using navigation/direction controls.', 'db-so-widgets'),
                            'default' => true
                        ),

                        'pause_on_hover' => array(
                            'type' => 'checkbox',
                            'label' => __('Pause on Hover', 'db-so-widgets'),
                            'description' => __('Should the slider pause on mouse hover over the slider.', 'db-so-widgets'),
                            'default' => true
                        ),

                        'direction_nav' => array(
                            'type' => 'checkbox',
                            'label' => __('Direction Navigation', 'db-so-widgets'),
                            'description' => __('Should the slider have direction navigation.', 'db-so-widgets'),
                            'default' => true
                        ),

                        'control_nav' => array(
                            'type' => 'checkbox',
                            'label' => __('Navigation Controls', 'db-so-widgets'),
                            'description' => __('Should the slider have navigation controls.', 'db-so-widgets')
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
                    'db-flexslider',
                    DBOW_PLUGIN_URL . 'assets/js/jquery.flexslider' . SOW_BUNDLE_JS_SUFFIX . '.js',
                    array('jquery'),
                    DBOW_VERSION
                ),
            )
        );

        $this->register_frontend_styles(
            array(
                array(
                    'db-flexslider',
                    DBOW_PLUGIN_URL . 'assets/css/flexslider.css',
                    array(),
                    DBOW_VERSION
                )
            )
        );


        $this->register_frontend_scripts(array(
            array(
                'db-testimonials-slider',
                plugin_dir_url(__FILE__) . 'js/testimonials' . SOW_BUNDLE_JS_SUFFIX . '.js',
                array('jquery')
            )
        ));

        $this->register_frontend_styles(array(
            array(
                'db-testimonials-slider',
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

siteorigin_widget_register('db-testimonials-slider', __FILE__, 'DBOW_Testimonials_Slider_Widget');