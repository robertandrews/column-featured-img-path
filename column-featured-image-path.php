<?php
/*
Plugin Name: Posts Column for Featured Image Path
Plugin URI: https://www.robertandrews.co.uk
Description: Adds a custom column to the Posts list which shows the path of any attached Featured Image.
Version: 1.0
Author: Robert Andrews
Author URI: https: //www.robertandrews.co.uk
License: GPL2
*/

// Add custom column for featured image path
add_filter('manage_posts_columns', 'custom_featured_image_column');
function custom_featured_image_column($columns)
{
    $columns['featured_image_path'] = __('Featured Image Path', 'text-domain');
    return $columns;
}

// Populate custom column with featured image path
add_action('manage_posts_custom_column', 'custom_featured_image_column_content', 10, 2);
function custom_featured_image_column_content($column_name, $post_id)
{
    if ('featured_image_path' === $column_name) {
        $featured_image_id = get_post_thumbnail_id($post_id);
        if ($featured_image_id) {
            $upload_dir = wp_upload_dir();
            $featured_image_path = get_post_meta($featured_image_id, '_wp_attached_file', true);
            $featured_image_url = $upload_dir['baseurl'] . '/' . $featured_image_path;
            $featured_image_path_parts = explode('wp-content', $featured_image_url);
            $featured_image_path = end($featured_image_path_parts);
            $featured_image_path = ltrim($featured_image_path, '/');
            echo $featured_image_path;
        }
    }
}


