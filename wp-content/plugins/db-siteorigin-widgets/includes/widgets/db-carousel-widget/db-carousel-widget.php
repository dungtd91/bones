<?php

/*
Widget Name: DB Carousel
Description: Display a list of custom HTML content as a carousel.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class DBOW_Carousel_Widget extends SiteOrigin_Widget {

    private $custom_css;

    function __construct() {
        parent::__construct(
            'db-carousel',
            __('DB Carousel', 'db-so-widgets'),
            array(
                'description' => __('Display a collection of html elements as a carousel.', 'db-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => 'http://portfoliotheme.org/widgets-bundle/carousel-widget-documentation/'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'db-so-widgets'),
                ),

                'elements' => array(
                    'type' => 'repeater',
                    'label' => __('HTML Elements', 'db-so-widgets'),
                    'item_name' => __('HTML Element', 'db-so-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='elements-name']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'name' => array(
                            'type' => 'text',
                            'label' => __('Name', 'db-so-widgets'),
                            'description' => __('The title to identify the HTML element', 'db-so-widgets'),
                        ),

                        'text' => array(
                            'type' => 'tinymce',
                            'label' => __('HTML element', 'db-so-widgets'),
                            'description' => __('The HTML content for the carousel item.', 'db-so-widgets'),
                        ),
                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('General Settings', 'db-so-widgets'),
                    'fields' => array(

                        'custom_css' => array(
                            'type' => 'textarea',
                            'label' => __('Custom CSS for presentation of the HTML elements. Will be embedded inline with the page.', 'db-so-widgets'),
                            'rows' => 20
                        ),
                    )
                ),

                'carousel_settings' => array(
                    'type' => 'section',
                    'label' => __('Carousel Settings', 'db-so-widgets'),
                    'fields' => array(

                        'arrows' => array(
                            'type' => 'checkbox',
                            'label' => __('Prev/Next Arrows?', 'db-so-widgets'),
                            'default' => true
                        ),

                        'dots' => array(
                            'type' => 'checkbox',
                            'label' => __('Show dot indicators for navigation?', 'db-so-widgets'),
                        ),

                        'autoplay' => array(
                            'type' => 'checkbox',
                            'label' => __('Autoplay?', 'db-so-widgets'),
                            'description' => __('Should the carousel autoplay as in a slideshow.', 'db-so-widgets'),
                            'default' => false
                        ),


                        'autoplay_speed' => array(
                            'type' => 'number',
                            'label' => __('Autoplay speed in ms', 'db-so-widgets'),
                            'default' => 3000
                        ),


                        'animation_speed' => array(
                            'type' => 'number',
                            'label' => __('Autoplay animation speed in ms', 'db-so-widgets'),
                            'default' => 300
                        ),

                        'pause_on_hover' => array(
                            'type' => 'checkbox',
                            'label' => __('Pause on mouse hover?', 'db-so-widgets'),
                            'default' => true
                        ),

                        'display_columns' => array(
                            'type' => 'slider',
                            'label' => __('Columns per row', 'db-so-widgets'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 3
                        ),

                        'scroll_columns' => array(
                            'type' => 'slider',
                            'label' => __('Columns to scroll', 'db-so-widgets'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 3
                        ),

                        'gutter' => array(
                            'type' => 'number',
                            'label' => __('Gutter', 'db-so-widgets'),
                            'description' => __('Space between columns.', 'db-so-widgets'),
                            'default' => 10
                        ),

                        'responsive' => array(
                            'type' => 'section',
                            'label' => __('Responsive', 'db-so-widgets'),
                            'hide' => true,
                            'fields' => array(
                                'tablet' => array(
                                    'type' => 'section',
                                    'label' => __('Tablet', 'db-so-widgets'),
                                    'fields' => array(
                                        'display_columns' => array(
                                            'type' => 'slider',
                                            'label' => __('Columns per row', 'db-so-widgets'),
                                            'min' => 1,
                                            'max' => 5,
                                            'integer' => true,
                                            'default' => 2
                                        ),
                                        'scroll_columns' => array(
                                            'type' => 'slider',
                                            'label' => __('Columns to scroll', 'db-so-widgets'),
                                            'min' => 1,
                                            'max' => 5,
                                            'integer' => true,
                                            'default' => 2
                                        ),
                                        'gutter' => array(
                                            'type' => 'number',
                                            'label' => __('Gutter', 'db-so-widgets'),
                                            'description' => __('Space between columns.', 'db-so-widgets'),
                                            'default' => 10
                                        ),
                                        'width' => array(
                                            'type' => 'text',
                                            'label' => __('Resolution', 'db-so-widgets'),
                                            'description' => __('The resolution to treat as a tablet resolution.', 'db-so-widgets'),
                                            'default' => 800,
                                            'sanitize' => 'intval',
                                        )
                                    )
                                ),
                                'mobile' => array(
                                    'type' => 'section',
                                    'label' => __('Mobile Phone', 'db-so-widgets'),
                                    'fields' => array(
                                        'display_columns' => array(
                                            'type' => 'slider',
                                            'label' => __('Columns per row', 'db-so-widgets'),
                                            'min' => 1,
                                            'max' => 5,
                                            'integer' => true,
                                            'default' => 1
                                        ),
                                        'scroll_columns' => array(
                                            'type' => 'slider',
                                            'label' => __('Columns to scroll', 'db-so-widgets'),
                                            'min' => 1,
                                            'max' => 5,
                                            'integer' => true,
                                            'default' => 1
                                        ),
                                        'gutter' => array(
                                            'type' => 'number',
                                            'label' => __('Gutter', 'db-so-widgets'),
                                            'description' => __('Space between columns.', 'db-so-widgets'),
                                            'default' => 10
                                        ),
                                        'width' => array(
                                            'type' => 'text',
                                            'label' => __('Resolution', 'db-so-widgets'),
                                            'description' => __('The resolution to treat as a mobile resolution.', 'db-so-widgets'),
                                            'default' => 480,
                                            'sanitize' => 'intval',
                                        )
                                    )
                                )

                            )
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
                    'db-slick-carousel',
                    DBOW_PLUGIN_URL . 'assets/js/slick' . SOW_BUNDLE_JS_SUFFIX . '.js',
                    array('jquery'),
                    DBOW_VERSION
                ),
            )
        );

        $this->register_frontend_styles(
            array(
                array(
                    'db-slick',
                    DBOW_PLUGIN_URL . 'assets/css/slick.css',
                    array(),
                    DBOW_VERSION
                ),
            )
        );

        $this->register_frontend_styles(array(
                array(
                    'db-carousel',
                    plugin_dir_url(__FILE__) . 'css/style.css'
                )
            )
        );

        add_action('wp_enqueue_scripts', array($this, 'init_custom_css'), 15); // load as late as possible

    }

    function modify_instance($instance) {
        return $instance;
    }

    function init_custom_css() {

        if (!is_active_widget(false, false, $this->id_base)) {
            return;
        }

        $custom_css = '';

        $instances = $this->get_settings();

        if (array_key_exists($this->number, $instances)) {
            $instance = $instances[$this->number];
            if (!empty($instance))
                $custom_css = $instance['settings']['custom_css'];
        }

        if ($custom_css <> '') {
            $custom_css = $custom_css . "\n";
            wp_add_inline_style('db-carousel', $custom_css); // after custom.css file
        }

    }

    function get_less_variables($instance) {
        return array(

            'gutter' => intval($instance['carousel_settings']['gutter']) . 'px',

            // All the responsive sizes
            'tablet_width' => intval($instance['carousel_settings']['responsive']['tablet']['width']) . 'px',
            'tablet_gutter' => intval($instance['carousel_settings']['responsive']['tablet']['gutter']) . 'px',
            'mobile_width' => intval($instance['carousel_settings']['responsive']['mobile']['width']) . 'px',
            'mobile_gutter' => intval($instance['carousel_settings']['responsive']['mobile']['gutter']) . 'px',
        );
    }

    function get_template_variables($instance, $args) {


        $return = array(
            'elements' => !empty($instance['elements']) ? $instance['elements'] : array(),
            'settings' => $instance['settings'],
            'carousel_settings' => $instance['carousel_settings']
        );

        unset($return['carousel_settings']['responsive']);

        $return['carousel_settings']['tablet_width'] = $instance['carousel_settings']['responsive']['tablet']['width'];
        $return['carousel_settings']['tablet_display_columns'] = $instance['carousel_settings']['responsive']['tablet']['display_columns'];
        $return['carousel_settings']['tablet_scroll_columns'] = $instance['carousel_settings']['responsive']['tablet']['scroll_columns'];
        $return['carousel_settings']['mobile_width'] = $instance['carousel_settings']['responsive']['mobile']['width'];
        $return['carousel_settings']['mobile_display_columns'] = intval($instance['carousel_settings']['responsive']['mobile']['display_columns']);
        $return['carousel_settings']['mobile_scroll_columns'] = $instance['carousel_settings']['responsive']['mobile']['scroll_columns'];

        return $return;
    }

}

siteorigin_widget_register('db-carousel', __FILE__, 'DBOW_Carousel_Widget');