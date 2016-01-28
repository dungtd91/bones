<?php

/*
Widget Name: DB Pricing Table
Description: Display pricing plans in a multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class DBOW_Pricing_Table_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'db-pricing-plans',
            __('DB Pricing Table', 'db-so-widgets'),
            array(
                'description' => __('Display pricing table in a multi-column grid.', 'db-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => 'http://portfoliotheme.org/widgets-bundle/pricing-widget-documentation/'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'db-so-widgets'),
                ),

                'pricing-plans' => array(
                    'type' => 'repeater',
                    'label' => __('Pricing Table', 'db-so-widgets'),
                    'item_name' => __('Pricing Plan', 'db-so-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='pricing-plans-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'pricing_title' => array(
                            'type' => 'text',
                            'label' => __('Pricing Plan Title', 'db-so-widgets'),
                            'description' => __('The title for the pricing plan', 'db-so-widgets'),
                        ),

                        'tagline' => array(
                            'type' => 'text',
                            'label' => __('Tagline Text', 'db-so-widgets'),
                            'description' => __('Provide any subtitle or taglines like "Most Popular", "Best Value", "Best Selling", "Most Flexible" etc. that you would like to use for this pricing plan.', 'db-so-widgets'),
                        ),

                        'image' => array(
                            'type' => 'media',
                            'label' => __('Image', 'db-so-widgets'),
                        ),

                        'price_tag' => array(
                            'type' => 'text',
                            'label' => __('Price Tag', 'db-so-widgets'),
                            'description' => __('Enter the price tag for the pricing plan. HTML is accepted.', 'db-so-widgets'),
                        ),

                        'button_text' => array(
                            'type' => 'text',
                            'label' => __('Text for Pricing Link/Button', 'db-so-widgets'),
                            'description' => __('Provide the text for the link or the button shown for this pricing plan.', 'db-so-widgets'),
                        ),

                        'url' => array(
                            'type' => 'link',
                            'label' => __('URL for the Pricing link/button', 'db-so-widgets'),
                            'description' => __('Provide the target URL for the link or the button shown for this pricing plan.', 'db-so-widgets'),
                        ),

                        'button_new_window' => array(
                            'type' => 'checkbox',
                            'label' => __('Open Button URL in a new window', 'db-so-widgets'),
                        ),

                        'highlight' => array(
                            'type' => 'checkbox',
                            'label' => __('Highlight Pricing Plan', 'db-so-widgets'),
                            'description' => __('Specify if you want to highlight the pricing plan.', 'db-so-widgets'),
                        ),

                        'items' => array(
                            'type' => 'repeater',
                            'label' => __('Pricing Plan Details', 'db-so-widgets'),
                            'item_name' => __('Pricing Item', 'db-so-widgets'),
                            'item_label' => array(
                                'selector' => "[id*='pricing-plans-items-text']",
                                'update_event' => 'change',
                                'value_method' => 'val'
                            ),
                            'fields' => array(
                                'title' => array(
                                    'type' => 'text',
                                    'label' => __('Title', 'db-so-widgets'),
                                ),
                                'value' => array(
                                    'type' => 'text',
                                    'label' => __('Value', 'db-so-widgets'),
                                ),
                                'icon_new' => array(
                                    'type' => 'icon',
                                    'label' => __('Icon', 'db-so-widgets'),
                                ),
                            ),
                        ),


                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'db-so-widgets'),
                    'fields' => array(

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __('Pricing Columns per row', 'db-so-widgets'),
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

        $this->register_frontend_styles(array(
            array(
                'db-pricing-plans',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'pricing_plans' => !empty($instance['pricing-plans']) ? $instance['pricing-plans'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('db-pricing-plans', __FILE__, 'DBOW_Pricing_Table_Widget');