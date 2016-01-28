<?php 

// 1. customize ACF path
add_filter('acf/settings/path', 'db_acf_settings_path');
 
function db_acf_settings_path( $path ) {
 
    // update path
    $path = get_stylesheet_directory() . '/extensions/acf/';
    
    // return
    return $path;
    
}
 

// 2. customize ACF dir
add_filter('acf/settings/dir', 'db_acf_settings_dir');
 
function db_acf_settings_dir( $dir ) {
 
    // update path
    $dir = get_stylesheet_directory_uri() . '/extensions/acf/';
    
    // return
    return $dir;
    
}
 

// 3. Show ACF field group menu item
add_filter('acf/settings/show_admin', '__return_true');


// 4. Include ACF
include_once( get_stylesheet_directory() . '/extensions/acf/acf.php' );
