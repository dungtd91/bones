<?php

/*
Widget Name: DB Hero Header
Description: Display custom header content with option to set HTML5/YouTube video or parallax image background.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class DBOW_Hero_Image_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'db-hero-image',
            __('DB Hero Header', 'db-so-widgets'),
            array(
                'description' => __('Display a hero background with video or image background.', 'db-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'db-so-widgets'),
                ),

                'header_type' => array(
                    'type' => 'radio',
                    'label' => __('Header Type', 'db-so-widgets'),
                    'default' => 'standard',
                    'state_emitter' => array(
                        'callback' => 'select',
                        'args' => array('header_type')
                    ),
                    'options' => array(
                        'standard' => __('Standard', 'db-so-widgets'),
                        'custom' => __('Custom', 'db-so-widgets'),
                    )
                ),

                'custom_header' => array(
                    'type' => 'section',
                    'label' => __('Custom Header', 'db-so-widgets'),
                    'state_handler' => array(
                        'header_type[custom]' => array('show'),
                        '_else[header_type]' => array('hide'),
                    ),
                    'fields' => array(
                        'custom' => array(
                            'type' => 'tinymce',
                            'label' => __('Custom text', 'db-so-widgets'),
                        ),

                        'custom_css' => array(
                            'type' => 'textarea',
                            'label' => __('Custom CSS for presentation of the Custom header elements. Will be embedded inline with the page.', 'db-so-widgets'),
                            'rows' => 20
                        ),
                    )
                ),


                'standard_header' => array(
                    'type' => 'section',
                    'label' => __('Standard Header', 'db-so-widgets'),
                    'state_handler' => array(
                        'header_type[standard]' => array('show'),
                        '_else[header_type]' => array('hide'),
                    ),
                    'fields' => array(
                        'heading' => array(
                            'type' => 'text',
                            'label' => __('Header text', 'db-so-widgets'),
                        ),

                        'subheading' => array(
                            'type' => 'text',
                            'label' => __('Sub-heading text', 'db-so-widgets'),
                            'optional' => 'true',
                        ),

                        'button_text' => array(
                            'type' => 'text',
                            'label' => __('Button text', 'db-so-widgets'),
                        ),

                        'button_url' => array(
                            'type' => 'link',
                            'label' => __('Button URL', 'db-so-widgets'),
                        ),

                        'new_window' => array(
                            'type' => 'checkbox',
                            'label' => __('Open URL in a new window', 'db-so-widgets'),
                        ),
                    )
                ),

                'pointer_down_url' => array(
                    'type' => 'text',
                    'label' => __('URL for Pointer Down', 'db-so-widgets'),
                    'description' => __('If an URL for the pointer down is specified, the hero image will sport a pointer down indicator to help user smooth scroll to the section indicated by this URL.', 'db-so-widgets'),
                ),

                'background' => array(
                    'type' => 'section',
                    'label' => __('Background', 'db-so-widgets'),
                    'fields' => array(

                        'bg_type' => array(
                            'type' => 'radio',
                            'label' => __('Background Type', 'db-so-widgets'),
                            'default' => 'parallax',
                            'state_emitter' => array(
                                'callback' => 'select',
                                'args' => array('bg_type')
                            ),
                            'options' => array(
                                'cover' => __('Cover Image', 'db-so-widgets'),
                                'parallax' => __('Parallax Image', 'db-so-widgets'),
                                'youtube' => __('YouTube Video', 'db-so-widgets'),
                                'html5video' => __('HTML5 Video', 'db-so-widgets'),
                            )
                        ),

                        'youtube_video' => array(
                            'type' => 'section',
                            'label' => __('YouTube Background Video', 'db-so-widgets'),
                            'state_handler' => array(
                                'bg_type[youtube]' => array('show'),
                                '_else[bg_type]' => array('hide'),
                            ),
                            'fields' => array(

                                'youtube_url' => array(
                                    'type' => 'text',
                                    'sanitize' => 'url',
                                    'label' => __('YouTube URL', 'db-so-widgets'),
                                    'description' => __('An URL of the YouTube video that will act as background video for this section.', 'db-so-widgets'),
                                ),

                                'quality' => array(
                                    'type' => 'select',
                                    'label' => __('Choose the YouTube video quality', 'db-so-widgets'),
                                    'default' => 'highres',
                                    'options' => array(
                                        'highres' => __('High Resolution', 'db-so-widgets'),
                                        'default' => __('Default', 'db-so-widgets'),
                                        'small' => __('Small', 'db-so-widgets'),
                                        'medium' => __('Medium', 'db-so-widgets'),
                                        'large' => __('Large', 'db-so-widgets'),
                                        'hd720' => __('HD 720p', 'db-so-widgets'),
                                        'hd1080' => __('HD 1080p', 'db-so-widgets'),
                                    )
                                ),

                                'ratio' => array(
                                    'type' => 'select',
                                    'label' => __('Aspect ratio of the YouTube video', 'db-so-widgets'),
                                    'default' => '16/9',
                                    'options' => array(
                                        '16/9' => __('16/9', 'db-so-widgets'),
                                        'auto' => __('Auto', 'db-so-widgets'),
                                        '4/3' => __('4/3', 'db-so-widgets'),
                                    )
                                ),

                            ),
                        ),

                        'html5_videos' => array(
                            'type' => 'section',
                            'label' => __('HTML5 Background videos', 'db-so-widgets'),
                            'state_handler' => array(
                                'bg_type[html5video]' => array('show'),
                                '_else[bg_type]' => array('hide'),
                            ),
                            'fields' => array(

                                'mp4_file' => array(
                                    'type' => 'media',
                                    'library' => 'video',
                                    'label' => __('MP4 Video file', 'db-so-widgets'),
                                ),
                                'webm_file' => array(
                                    'type' => 'media',
                                    'library' => 'video',
                                    'label' => __('WebM Video file', 'db-so-widgets'),
                                ),
                                'ogg_file' => array(
                                    'type' => 'media',
                                    'library' => 'video',
                                    'label' => __('Ogg Video file', 'db-so-widgets'),
                                ),

                            ),
                        ),

                        'bg_image' => array(
                            'type' => 'section',
                            'label' => __('Background Image', 'db-so-widgets'),
                            'fields' => array(

                                'image' => array(
                                    'type' => 'media',
                                    'label' => __('Background Image', 'db-so-widgets'),
                                    'label' => __('This background image will be used as a placeholder image if YouTube or HTML5 video background option is chosen.', 'db-so-widgets'),
                                    'library' => 'image',
                                    'fallback' => true,
                                ),
                            ),
                        ),

                        'overlay' => array(
                            'type' => 'section',
                            'label' => __('Background Overlay', 'db-so-widgets'),
                            'fields' => array(

                                'overlay_color' => array(
                                    'type' => 'color',
                                    'label' => __('Overlay color', 'db-so-widgets'),
                                    'default' => '#333333',
                                ),

                                'overlay_opacity' => array(
                                    'label' => __('Overlay opacity', 'db-so-widgets'),
                                    'type' => 'slider',
                                    'min' => 0,
                                    'max' => 100,
                                    'default' => 30,
                                ),

                            ),
                        ),
                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'db-so-widgets'),
                    'fields' => array(

                        'top_padding' => array(
                            'type' => 'number',
                            'label' => __('Top padding', 'db-so-widgets'),
                            'default' => 100,
                        ),

                        'bottom_padding' => array(
                            'type' => 'number',
                            'label' => __('Bottom padding', 'db-so-widgets'),
                            'default' => 100,
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
                                        'top_padding' => array(
                                            'type' => 'number',
                                            'label' => __('Top padding', 'db-so-widgets'),
                                            'default' => 80,
                                        ),

                                        'bottom_padding' => array(
                                            'type' => 'number',
                                            'label' => __('Bottom padding', 'db-so-widgets'),
                                            'default' => 80,
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
                                        'top_padding' => array(
                                            'type' => 'number',
                                            'label' => __('Top padding', 'db-so-widgets'),
                                            'default' => 50,
                                        ),

                                        'bottom_padding' => array(
                                            'type' => 'number',
                                            'label' => __('Bottom padding', 'db-so-widgets'),
                                            'default' => 50,
                                        ),

                                        'width' => array(
                                            'type' => 'text',
                                            'label' => __('Resolution', 'db-so-widgets'),
                                            'description' => __('The resolution to treat as a mobile resolution.', 'db-so-widgets'),
                                            'default' => 400,
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
                    'db-ytp',
                    DBOW_PLUGIN_URL . 'assets/js/jquery.mb.YTPlayer' . SOW_BUNDLE_JS_SUFFIX . '.js',
                    array('jquery'),
                    DBOW_VERSION
                ),
            )
        );

        $this->register_frontend_styles(array(
            array(
                'db-hero-image',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));


        add_action('wp_enqueue_scripts', array($this, 'init_custom_css'), 15); // load as late as possible

    }

    function init_custom_css() {

        if (!is_active_widget(false, false, $this->id_base)) {
            return;
        }

        $custom_css = '';

        $instances = $this->get_settings();

        if (array_key_exists($this->number, $instances)) {
            $instance = $instances[$this->number];
            if (!empty($instance)) {
                $header_type = $instance['header_type'];
                if ($header_type == 'custom')
                    $custom_css = $instance['custom_header']['custom_css'];
            }
        }

        if ($custom_css <> '') {
            $custom_css = $custom_css . "\n";
            wp_add_inline_style('db-hero-image', $custom_css); // after custom.css file
        }

    }


    function get_less_variables($instance) {
        return array(
            'top_padding' => intval($instance['settings']['top_padding']) . 'px',
            'bottom_padding' => intval($instance['settings']['bottom_padding']) . 'px',

            'tablet_width' => intval($instance['settings']['responsive']['tablet']['width']) . 'px',
            'mobile_width' => intval($instance['settings']['responsive']['mobile']['width']) . 'px',

            'tablet_top_padding' => intval($instance['settings']['responsive']['tablet']['top_padding']) . 'px',
            'tablet_bottom_padding' => intval($instance['settings']['responsive']['tablet']['bottom_padding']) . 'px',

            'mobile_top_padding' => intval($instance['settings']['responsive']['mobile']['top_padding']) . 'px',
            'mobile_bottom_padding' => intval($instance['settings']['responsive']['mobile']['bottom_padding']) . 'px',
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            'header_type' => $instance['header_type'],
            'custom_header' => $instance['custom_header'],
            'standard_header' => $instance['standard_header'],
            'pointer_down_url' => $instance['pointer_down_url'],
            'background' => $instance['background'],
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('db-hero-image', __FILE__, 'DBOW_Hero_Image_Widget');