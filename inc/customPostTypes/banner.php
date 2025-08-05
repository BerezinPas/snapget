<?php

/**
 * This is an example file showcasing how you can add custom Banners to your Flynt theme.
 *
 * For a full list of parameters see https://developer.wordpress.org/reference/functions/register_post_type/ or use https://generatewp.com/post-type/ to generate the code for you.
 */

namespace Flynt\CustomPostTypes;

add_action('init', function () {
    $labels = [
        'name'                  => _x('Banners', 'Banner General Name', 'flynt'),
        'singular_name'         => _x('Banner', 'Banner Singular Name', 'flynt'),
        'menu_name'             => __('Banners', 'flynt'),
        'name_admin_bar'        => __('Banner', 'flynt'),
        'archives'              => __('Banner Archives', 'flynt'),
        'attributes'            => __('Banner Attributes', 'flynt'),
        'parent_item_colon'     => __('Parent Banner:', 'flynt'),
        'all_items'             => __('All Banners', 'flynt'),
        'add_new_item'          => __('Add New Banner', 'flynt'),
        'add_new'               => __('Add New', 'flynt'),
        'new_item'              => __('New Banner', 'flynt'),
        'edit_item'             => __('Edit Banner', 'flynt'),
        'update_item'           => __('Update Banner', 'flynt'),
        'view_item'             => __('View Banner', 'flynt'),
        'view_items'            => __('View Banners', 'flynt'),
        'search_items'          => __('Search Banner', 'flynt'),
        'not_found'             => __('Not found', 'flynt'),
        'not_found_in_trash'    => __('Not found in Trash', 'flynt'),
        'featured_image'        => __('Featured Image', 'flynt'),
        'set_featured_image'    => __('Set featured image', 'flynt'),
        'remove_featured_image' => __('Remove featured image', 'flynt'),
        'use_featured_image'    => __('Use as featured image', 'flynt'),
        'insert_into_item'      => __('Insert into item', 'flynt'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'flynt'),
        'items_list'            => __('Banners list', 'flynt'),
        'items_list_navigation' => __('Banners list navigation', 'flynt'),
        'filter_items_list'     => __('Filter banners list', 'flynt'),
    ];
    $args = [
        'label'                 => __('Banner', 'flynt'),
        'description'           => __('Banner Description', 'flynt'),
        'labels'                => $labels,
        'supports'              => ['title', 'custom-fields', 'page-attributes'],
        'taxonomies'            => [],
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-money',
        'menu_position'         => 5,
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => false,
        'has_archive'           => false,
        'publicly_queryable'    => false,
        'exclude_from_search'   => true,
        'capability_type'       => 'post',
    ];
    register_post_type('banner', $args);
});
