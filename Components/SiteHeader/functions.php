<?php

namespace Flynt\Components\SiteHeader;

use Flynt\Utils\Asset;
use Flynt\Utils\Options;
use Timber\Timber;

add_action('init', function () {
    register_nav_menus([
        'heder_nav' => __('Header Nav', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=SiteHeader', function ($data) {
    $data['menu'] = Timber::get_menu('heder_nav') ?? Timber::get_pages_menu();
    $data['logo'] = [
        'src' => get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : Asset::requireUrl('assets/images/header-logo.svg'),
        'alt' => get_bloginfo('name')
    ];

    // $user = Timber::get_user();
    // var_dump($user);

    return $data;
});

Options::addTranslatable('SiteHeader', [
    [
        'label' => __('Button', 'flynt'),
        'name' => 'button',
        'type' => 'text',
        'required' => 1,
        'default_value' => __('Category', 'flynt'),
    ],
    [
        'label' => __('Dark theme', 'flynt'),
        'name' => 'dark_theme',
        'type' => 'text',
        'required' => 1,
        'default_value' => __('Dark theme', 'flynt'),

    ],
    [
        'label' => __('Search Placeholder', 'flynt'),
        'name' => 'searchPlaceholder',
        'type' => 'text',
        'required' => 1,
        'default_value' => __('Search', 'flynt'),

    ],
    [
        'label' => __('User Profile', 'flynt'),
        'name' => 'user_profile',
        'type' => 'text',
        'default_value' => __('User Profile', 'flynt')
    ],
    [
        'label' => __('Favourites', 'flynt'),
        'name' => 'favourites',
        'type' => 'text',
        'default_value' => __('Favourites', 'flynt')
    ],
    [
        'label' => __('Support', 'flynt'),
        'name' => 'support',
        'type' => 'text',
        'default_value' => __('Support', 'flynt')
    ],
    [
        'label' => __('Logout', 'flynt'),
        'name' => 'logout',
        'type' => 'text',
        'default_value' => __('Logout', 'flynt')
    ],
]);
