<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;


if (!function_exists('db_get_terms')) {

    function db_get_terms($taxonomy) {

        global $wpdb;

        $term_coll = array();

        if (taxonomy_exists($taxonomy)) {
            $terms = get_terms($taxonomy); // Get all terms of a taxonomy

            if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $term_coll[$term->term_id] = $term->name;
                }
            }
        }
        else {

            $qt = 'SELECT * FROM ' . $wpdb->terms . ' AS t INNER JOIN ' . $wpdb->term_taxonomy . ' AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy =  "' . $taxonomy . '" AND tt.count > 0 ORDER BY  t.term_id DESC LIMIT 0 , 30';

            $terms = $wpdb->get_results($qt, ARRAY_A);

            if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $term_coll[$term['term_id']] = $term['name'];
                }
            }
        }

        return $term_coll;
    }
}

if (!function_exists('db_entry_terms_list')) {

    function db_entry_terms_list($taxonomy = 'category', $separator = ', ', $before = ' ', $after = ' ') {
        global $post;

        $output = '<span class="db-' . $taxonomy . '-list">';
        $output .= get_the_term_list($post->ID, $taxonomy, $before, $separator, $after);
        $output .= '</span>';

        return $output;
    }
}

if (!function_exists('db_get_posts')) {

    function db_get_posts() {

        $list = array();

        $args = $args = array(
            'posts_per_page' => -1,
            'offset' => 0,
            'category' => '',
            'category_name' => '',
            'orderby' => 'date',
            'order' => 'DESC',
            'include' => '',
            'exclude' => '',
            'meta_key' => '',
            'meta_value' => '',
            'post_type' => 'post',
            'post_mime_type' => '',
            'post_parent' => '',
            'author' => '',
            'post_status' => 'publish',
            'suppress_filters' => true
        );

        $posts = get_posts($args);

        if (!empty ($posts)) {
            foreach ($posts as $post) {
                $list[$post->ID] = $post->post_title;
            }
        }

        return $list;
    }
}

if (!function_exists('db_get_taxonomy_info')) {

    function db_get_taxonomy_info($taxonomy) {
        $output = '';
        $terms = get_the_terms(get_the_ID(), $taxonomy);
        if ($terms) {
            $output .= '<div class="db-terms">';
            $term_count = 0;
            foreach ($terms as $term) {
                if ($term_count != 0)
                    $output .= ', ';
                $output .= '<a href="' . get_term_link($term->slug, $taxonomy) . '">' . $term->name . '</a>';
                $term_count = $term_count + 1;
            }
            $output .= '</div>';
        }
        return $output;
    }
}


/** Isotope filtering support for Portfolio pages * */

if (!function_exists('db_get_taxonomy_terms_filter')) {

    function db_get_taxonomy_terms_filter($taxonomy, $chosen_terms = array()) {

        $output = '';

        $terms = get_terms($taxonomy);

        if (!empty($terms)) {

            $output .= '<div class="db-taxonomy-filter">';

            $output .= '<div class="db-filter-item segment-0 db-active"><a data-value="*" href="#">' . esc_html__('All', 'db-so-widgets') . '</a></div>';

            $segment_count = 1;
            foreach ($terms as $term) {

                if (!empty($chosen_terms) && !in_array($term->term_id, $chosen_terms))
                    continue; // skip if this is not a chosen term

                $output .= '<div class="db-filter-item segment-' . intval($segment_count) . '"><a href="#" data-value=".term-' . intval($term->term_id) . '" title="' . esc_html__('View all items filed under ', 'peak') . esc_attr($term->name) . '">' . esc_html($term->name) . '</a></div>';

                $segment_count++;
            }

            $output .= '</div>';

        }

        return $output;
    }
}

/* Return the css class name to help achieve the number of columns specified */

if (!function_exists('db_get_column_class')) {

    function db_get_column_class($column_size = 3, $no_margin = false) {

        $style_class = 'db-threecol';

        $no_margin = db_to_boolean($no_margin); // make sure it is not string

        $column_styles = array(
            1 => 'db-twelvecol',
            2 => 'db-sixcol',
            3 => 'db-fourcol',
            4 => 'db-threecol',
            5 => 'db-onefifthcol',
            6 => 'db-twocol',
            12 => 'db-onecol'
        );

        if (array_key_exists($column_size, $column_styles) && !empty($column_styles[$column_size])) {
            $style_class = $column_styles[$column_size];
        }

        $style_class = $no_margin ? ($style_class . ' db-zero-margin') : $style_class;

        return $style_class;
    }
}

/*
* Converting string to boolean is a big one in PHP
*/
if (!function_exists('db_to_boolean')) {

    function db_to_boolean($value) {
        if (!isset($value))
            return false;
        if ($value == 'true' || $value == '1')
            $value = true;
        elseif ($value == 'false' || $value == '0')
            $value = false;
        return (bool)$value; // Make sure you do not touch the value if the value is not a string
    }
}
