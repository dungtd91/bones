<?php

define("DB_WIDGET_PATH", dirname(__FILE__));
define("DB_WIDGET_URL", get_template_directory_uri() . '/inc/widgets/extra-widgets/');

function db_widgets_bundle( $folders ) {
	$folders[] = dirname(__FILE__) . '/extra-widgets/';

	return $folders;
}
add_filter( 'siteorigin_widgets_widget_folders', 'db_widgets_bundle' );

/**
 * Add pannel Group
 */
function db_so_panels_widget_dialog_tabs($tabs) {
	$tabs[] = array(
			'title' => __('DB Addon Bundle', 'db'),
			'filter' => array(
					'groups' => array('db_addonso')
			)
	);

	return $tabs;
}
add_filter('siteorigin_panels_widget_dialog_tabs', 'db_so_panels_widget_dialog_tabs', 20);