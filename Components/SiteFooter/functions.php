<?php

namespace Flynt\Components\SiteFooter;

use Flynt\Utils\Asset;
use Flynt\Utils\Options;
use Timber\Timber;

add_action('init', function () {
    register_nav_menus([
        'footer_nav' => __('Foote Nav', 'flynt'),
        'footer_menu' => __('Foote Menu', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=SiteFooter', function ($data) {
    $data['nav']  = Timber::get_menu('footer_nav') ?? Timber::get_pages_menu();
    $data['menu'] = Timber::get_menu('footer_menu') ?? Timber::get_pages_menu();
    $data['logo'] = [
        'src' => get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : Asset::requireUrl('assets/images/footer-logo.svg'),
        'alt' => get_bloginfo('name')
    ];

    $options = get_fields('options');

    $data['options'] = $options;
    $data['socials'] = $options['global_SocialLinks_items'] ?? null;

    return $data;
});

Options::addGlobal('SiteFooter', [
    [
      'label' => __('Text', 'flynt'),
      'name' => 'text',
      'type' => 'textarea',
      'default_value' => __('', 'flynt'),
    ],
  ]);
