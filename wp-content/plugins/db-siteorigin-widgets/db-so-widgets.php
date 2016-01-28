<?php
/**
 * Plugin Name: DB SiteOrigin Widgets
 * Plugin URI: digibeaver.com
 * Description: A collection of premium quality widgets for use in any widgetized area or in SiteOrigin page builder. SiteOrigin Widgets Bundle is required.
 * Author: DB
 * Author URI: http://portfoliotheme.org/
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Version: 1.0
 * Text Domain: db-so-widgets
 * Domain Path: languages
 *
 * DB SiteOrigin Widgets is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * DB SiteOrigin Widgets is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DB SiteOrigin Widgets. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'DB_SiteOrigin_Widgets' ) ) :

	/**
	 * Main DB_SiteOrigin_Widgets Class
	 *
	 */
	final class DB_SiteOrigin_Widgets {

		/** Singleton *************************************************************/

		private static $instance;

		/**
		 * Main DB_SiteOrigin_Widgets Instance
		 *
		 * Insures that only one instance of DB_SiteOrigin_Widgets exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof DB_SiteOrigin_Widgets ) ) {
				self::$instance = new DB_SiteOrigin_Widgets;
				self::$instance->setup_constants();

				add_action( 'plugins_loaded', array( self::$instance, 'load_plugin_textdomain' ) );

				self::$instance->includes();

				self::$instance->hooks();


			}

			return self::$instance;
		}

		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'db-so-widgets' ), '1.6' );
		}

		/**
		 * Disable unserializing of the class
		 *
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'db-so-widgets' ), '1.6' );
		}

		/**
		 * Setup plugin constants
		 *
		 */
		private function setup_constants() {

			// Plugin version
			if ( ! defined( 'DBOW_VERSION' ) ) {
				define( 'DBOW_VERSION', '1.0' );
			}

			// Plugin Folder Path
			if ( ! defined( 'DBOW_PLUGIN_DIR' ) ) {
				define( 'DBOW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL
			if ( ! defined( 'DBOW_PLUGIN_URL' ) ) {
				define( 'DBOW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File
			if ( ! defined( 'DBOW_PLUGIN_FILE' ) ) {
				define( 'DBOW_PLUGIN_FILE', __FILE__ );
			}
		}

		/**
		 * Include required files
		 *
		 */
		private function includes() {

			require_once DBOW_PLUGIN_DIR . 'includes/class-db-setup.php';
			require_once DBOW_PLUGIN_DIR . 'includes/helper-functions.php';
			require_once DBOW_PLUGIN_DIR . 'includes/aq_resizer.php';

		}

		/**
		 * Load Plugin Text Domain
		 *
		 * Looks for the plugin translation files in certain directories and loads
		 * them to allow the plugin to be localised
		 */
		public function load_plugin_textdomain() {

			$lang_dir = apply_filters( 'db_reviews_lang_dir', trailingslashit( DBOW_PLUGIN_DIR . 'languages' ) );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), 'db-so-widgets' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'db-so-widgets', $locale );

			// Setup paths to current locale file
			$mofile_local = $lang_dir . $mofile;

			if ( file_exists( $mofile_local ) ) {
				// Look in the /wp-content/plugins/db-so-widgets/languages/ folder
				load_textdomain( 'db-so-widgets', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'db-so-widgets', false, $lang_dir );
			}

			return false;
		}

		/**
		 * Setup the default hooks and actions
		 */
		private function hooks() {

			add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ), 100 );

			add_action( 'wp_enqueue_scripts', array( $this, 'load_frontend_scripts' ), 100 );
		}

		/**
		 * Load Frontend Scripts/Styles
		 *
		 */
		public function load_frontend_scripts() {

			// Use minified libraries if SCRIPT_DEBUG is turned off
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_register_style( 'db-frontend-styles', DBOW_PLUGIN_URL . 'assets/css/db-frontend.css', array(), DBOW_VERSION );
			wp_enqueue_style( 'db-frontend-styles' );

			wp_register_style( 'db-icomoon-styles', DBOW_PLUGIN_URL . 'assets/css/icomoon.css', array(), DBOW_VERSION );
			wp_enqueue_style( 'db-icomoon-styles' );

			wp_register_script( 'db-frontend-scripts', DBOW_PLUGIN_URL . 'assets/js/db-frontend' . $suffix . '.js', array(), DBOW_VERSION, true );
			wp_enqueue_script( 'db-frontend-scripts' );

		}

		/**
		 * Load Admin Scripts/Styles
		 *
		 */
		public function load_admin_scripts() {

			// Use minified libraries if SCRIPT_DEBUG is turned off
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_register_style( 'db-admin-styles', DBOW_PLUGIN_URL . 'assets/css/db-admin.css', array(), DBOW_VERSION );
			wp_enqueue_style( 'db-admin-styles' );

			wp_register_script( 'db-admin-scripts', DBOW_PLUGIN_URL . 'assets/js/db-admin' . $suffix . '.js', array(), DBOW_VERSION, true );
			wp_enqueue_script( 'db-admin-scripts' );

			wp_enqueue_script( 'jquery-ui-datepicker' );
		}

	}

endif; // End if class_exists check


/**
 * The main function responsible for returning the one true DB_SiteOrigin_Widgets
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $db = DB(); ?>
 */
function DB() {
	return DB_SiteOrigin_Widgets::instance();
}

// Get DB Running
DB();