<?php
/**
 * db functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package db
 */

if ( ! function_exists( 'db_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function db_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on db, use a find and replace
		 * to change 'db' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'db', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'db' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'db_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
	}
endif; // db_setup
add_action( 'after_setup_theme', 'db_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function db_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'db_content_width', 1140 );
}

add_action( 'after_setup_theme', 'db_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function db_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'db' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
			'name'          => esc_html__( 'Footer', 'db' ),
			'id'            => 'sidebar-footer',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	) );
}

add_action( 'widgets_init', 'db_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function db_scripts() {

	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/layouts/bootstrap.min.css');

	wp_enqueue_style('bootstrap-theme', get_template_directory_uri() . '/layouts/bootstrap-theme.min.css');

	wp_enqueue_style( 'db-style', get_stylesheet_uri() );

	wp_enqueue_script( 'db-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'db-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'db_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Advanced Custom Fields PRO.
 */
require get_template_directory() . '/extensions/acf/acf-config.php';

/**
 * Include the TGM_Plugin_Activation class.
 */
require get_template_directory() . '/extensions/class-tgm-plugin-activation.php';

/**
 * Include the SO Page Builder Animate.
 */
require get_template_directory() . '/extensions/so-page-builder-animate/so-page-builder-animate.php';

/**
 * Include Widgets sidebar.
 */
require get_template_directory() . '/extensions/widgets/recent-posts-widget.php';
require get_template_directory() . '/extensions/widgets/related-posts-widget.php';

/**
 * Load Theme Specials
 */
require get_template_directory() . '/inc/theme/theme.php';

/**
 * Include the SO Page Builder Widgets.
 */
require get_template_directory() . '/inc/widgets/db-widgets.php';