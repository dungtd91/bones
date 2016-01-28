<?php

/*
Widget Name: DB Portfolio
Description: Display portfolio items from Jetpack custom post types in multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class DBOW_Portfolio_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'db-portfolio',
            __('DB Portfolio', 'db-so-widgets'),
            array(
                'description' => __('Showcase your work or products with a filterable portfolio layout. Make sure that Custom Post Types module in active in Jetpack plugin', 'db-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => 'http://portfoliotheme.org/widgets-bundle/portfolio-widget-documentation/'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'db-so-widgets'),
                ),

                'heading' => array(
                    'type' => 'text',
                    'label' => __('Heading for the portfolio', 'db-so-widgets'),
                ),

                'terms' => array(
                    'type' => 'select',
                    'label' => __('Optionally choose one or more categories/project types for display of portfolio items. If none chosen, items from all of the categories are displayed.', 'db-so-widgets'),
                    'multiple' => true,
                    'options' => db_get_terms('jetpack-portfolio-type')
                ),

                'post_count' => array(
                    'type' => 'number',
                    'label' => __('Enter the total number of projects to display. If blank or zero, all projects are displayed.', 'db-so-widgets'),
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'db-so-widgets'),
                    'fields' => array(

                        'filterable' => array(
                            'type' => 'checkbox',
                            'label' => __('Filterable?', 'db-so-widgets'),
                            'default' => true
                        ),

                        'layout_mode' => array(
                            'type' => 'select',
                            'label' => __('Choose a layout for the portfolio', 'db-so-widgets'),
                            'state_emitter' => array(
                                'callback' => 'select',
                                'args' => array('layout_mode')
                            ),
                            'default' => 'fitRows',
                            'options' => array(
                                'fitRows' => __('Fit Rows', 'db-so-widgets'),
                                'masonry' => __('Masonry', 'db-so-widgets'),
                            )
                        ),

                        'packed' => array(
                            'type' => 'checkbox',
                            'label' => __('Packed Layout?', 'db-so-widgets'),
                            'state_handler' => array(
                                'layout_mode[fitRows]' => array('show'),
                                'layout_mode[masonry]' => array('hide'),
                            ),
                            'default' => false
                        ),

                        'image_linkable' => array(
                            'type' => 'checkbox',
                            'label' => __('Link the image to the portfolio?', 'db-so-widgets'),
                            'default' => true
                        ),

                        'display_title' => array(
                            'type' => 'checkbox',
                            'label' => __('Display project title below the portfolio item?', 'db-so-widgets'),
                            'default' => true
                        ),

                        'display_summary' => array(
                            'type' => 'checkbox',
                            'label' => __('Display project excerpt/summary below the portfolio item?', 'db-so-widgets'),
                            'default' => true
                        ),

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __('Columns per row', 'db-so-widgets'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 4
                        ),

                        'gutter' => array(
                            'type' => 'number',
                            'label' => __('Masonry Gutter', 'db-so-widgets'),
                            'state_handler' => array(
                                'layout_mode[masonry]' => array('show'),
                                'layout_mode[fitRows]' => array('hide'),
                            ),
                            'description' => __('Space between columns in masonry grid.', 'db-so-widgets'),
                            'default' => 20
                        ),

                        'responsive' => array(
                            'type' => 'section',
                            'label' => __('Responsive', 'db-so-widgets'),
                            'hide' => true,
                            'state_handler' => array(
                                'layout_mode[masonry]' => array('show'),
                                'layout_mode[fitRows]' => array('hide'),
                            ),
                            'fields' => array(
                                'tablet' => array(
                                    'type' => 'section',
                                    'label' => __('Tablet', 'db-so-widgets'),
                                    'fields' => array(

                                        'gutter' => array(
                                            'type' => 'number',
                                            'label' => __('Gutter', 'db-so-widgets'),
                                            'description' => __('Space between columns in masonry layout.', 'db-so-widgets'),
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

                                        'gutter' => array(
                                            'type' => 'number',
                                            'label' => __('Gutter', 'db-so-widgets'),
                                            'description' => __('Space between columns in masonry layout.', 'db-so-widgets'),
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
                    'db-isotope',
                    DBOW_PLUGIN_URL . 'assets/js/isotope.pkgd' . SOW_BUNDLE_JS_SUFFIX . '.js',
                    array('jquery'),
                    DBOW_VERSION
                ),
                array(
                    'db-imagesloaded',
                    DBOW_PLUGIN_URL . 'assets/js/imagesloaded.pkgd' . SOW_BUNDLE_JS_SUFFIX . '.js',
                    array('jquery'),
                    DBOW_VERSION
                ),
            )
        );


        $this->register_frontend_scripts(array(
                array(
                    'db-portfolio',
                    plugin_dir_url(__FILE__) . 'js/portfolio' . SOW_BUNDLE_JS_SUFFIX . '.js',
                    array('jquery')
                )
            )
        );

        $this->register_frontend_styles(array(
                array(
                    'db-portfolio',
                    plugin_dir_url(__FILE__) . 'css/style.css'
                )
            )
        );
    }


    function get_less_variables($instance) {
        return array(

            'gutter' => intval($instance['settings']['gutter']) . 'px',

            // All the responsive sizes
            'tablet_width' => intval($instance['settings']['responsive']['tablet']['width']) . 'px',
            'tablet_gutter' => intval($instance['settings']['responsive']['tablet']['gutter']) . 'px',
            'mobile_width' => intval($instance['settings']['responsive']['mobile']['width']) . 'px',
            'mobile_gutter' => intval($instance['settings']['responsive']['mobile']['gutter']) . 'px',
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            'post_count' => $instance['post_count'],
            'heading' => $instance['heading'],
            'terms' => is_string($instance['terms']) ? array($instance['terms']) : $instance['terms'],
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('db-portfolio', __FILE__, 'DBOW_Portfolio_Widget');