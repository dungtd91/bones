<?php

/*
Widget Name: DB Team Members
Description: Display a list of your team members optionally in a multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class DBOW_Team_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'db-team-members',
            __('DB Team Members', 'db-so-widgets'),
            array(
                'description' => __('Create team members to display in a column grid.', 'db-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => 'http://portfoliotheme.org/widgets-bundle/team-members-widget-documentation/'
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

                'team-members' => array(
                    'type' => 'repeater',
                    'label' => __('Team Members', 'db-so-widgets'),
                    'item_name' => __('Team Member', 'db-so-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='team-members-name']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'name' => array(
                            'type' => 'text',
                            'label' => __('Name', 'db-so-widgets'),
                            'description' => __('Name of the team member.', 'db-so-widgets'),
                        ),

                        'image' => array(
                            'type' => 'media',
                            'label' => __('Team member image.', 'db-so-widgets'),
                        ),

                        'position' => array(
                            'type' => 'text',
                            'label' => __('Position', 'db-so-widgets'),
                            'description' => __('Specify the position/title of the team member.', 'db-so-widgets'),
                        ),

                        'details' => array(
                            'type' => 'textarea',
                            'label' => __('Short details', 'db-so-widgets'),
                            'description' => __('Provide a short writeup for the team member', 'db-so-widgets'),
                        ),


                        'social_profile' => array(
                            'type' => 'section',
                            'label' => __('Social profile', 'db-so-widgets'),
                            'fields' => array(
                                'email_address' => array(
                                    'type' => 'text',
                                    'label' => __('Email Address', 'db-so-widgets'),
                                    'description' => __('Enter the email address of the team member.', 'db-so-widgets'),
                                ),

                                'facebook' => array(
                                    'type' => 'text',
                                    'label' => __('Facebook Page URL', 'db-so-widgets'),
                                    'description' => __('URL of the Facebook page of the team member.', 'db-so-widgets'),
                                ),

                                'twitter' => array(
                                    'type' => 'text',
                                    'label' => __('Twitter Profile URL', 'db-so-widgets'),
                                    'description' => __('URL of the Twitter page of the team member.', 'db-so-widgets'),
                                ),

                                'linkedin' => array(
                                    'type' => 'text',
                                    'label' => __('LinkedIn Page URL', 'db-so-widgets'),
                                    'description' => __('URL of the LinkedIn profile of the team member.', 'db-so-widgets'),
                                ),

                                'pinterest' => array(
                                    'type' => 'text',
                                    'label' => __('Pinterest Page URL', 'db-so-widgets'),
                                    'description' => __('URL of the Pinterest page for the team member.', 'db-so-widgets'),
                                ),

                                'dribbble' => array(
                                    'type' => 'text',
                                    'label' => __('Dribbble Profile URL', 'db-so-widgets'),
                                    'description' => __('URL of the Dribbble profile of the team member.', 'db-so-widgets'),
                                ),

                                'google_plus' => array(
                                    'type' => 'text',
                                    'label' => __('GooglePlus Page URL', 'db-so-widgets'),
                                    'description' => __('URL of the Google Plus page of the team member.', 'db-so-widgets'),
                                ),

                                'instagram' => array(
                                    'type' => 'text',
                                    'label' => __('Instagram Page URL', 'db-so-widgets'),
                                    'description' => __('URL of the Instagram feed for the team member.', 'db-so-widgets'),
                                ),

                            )
                        ),

                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'db-so-widgets'),
                    'state_handler' => array(
                        'style[style1]' => array('show'),
                        'style[style2]' => array('hide'),
                    ),
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
                'db-team-members',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_style_name($instance) {
        if ($instance['style'] == 'style2')
            return false; // no stylesheet required for style 2 template
        return $instance['style'];
    }

    function get_template_variables($instance, $args) {
        return array(
            'style' => $instance['style'],
            'team_members' => !empty($instance['team-members']) ? $instance['team-members'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('db-team-members', __FILE__, 'DBOW_Team_Widget');