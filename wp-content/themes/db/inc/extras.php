<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package db
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function db_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'db_body_classes' );

/**
 * Enqueue Fonts
 */

function db_google_font_enqueue() {
	$fonts = get_field('db_fonts', 'options');
	if( empty( $fonts ) ) {
		return;
	}
	$subsets = array();
	$font_element = array();
	foreach( $fonts as $font ) {
		$font = $font['db_font'];
		$subsets = array_merge( $subsets, $font['subsets'] );
		$font_name = str_replace( ' ', '+', $font['font'] );
		if( $font['variants'] == array( 'regular' ) ) {
			$font_element[] = $font_name;
		}
		else {
			$regular_variant = array_search( 'regular', $font['variants'] );
			if( $regular_variant !== false ) {
				$font['variants'][$regular_variant] = '400';
			}
			$font_element[] = $font_name . ':' . implode( ',', $font['variants'] );
		}

	}

	$subsets = ( empty( $subsets ) ) ? array('latin') : array_unique( $subsets );
	$subset_string = implode( ',', $subsets );
	$font_string = implode( '|', $font_element );
	$request = '//fonts.googleapis.com/css?family=' . $font_string . '&subset=' . $subset_string;

	return $request;
}

/*
 * aq_resize return false;
 *
 */
function db_aq_resize($image_url) {
	$imageID = attachment_url_to_postid($image_url);
	$imageObj = wp_get_attachment_metadata($imageID);
	return array(
		$image_url,
		$imageObj['width'],
		$imageObj['height']
	);
}
