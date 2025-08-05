<?php

namespace Flynt\Components\BannerSidebar;

use Timber\Timber;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=BannerSidebar', function ($data) {
    $banners = Timber::get_posts([
        'post_status' => 'publish',
        'post_type' => 'banner',
        'orderby' => 'rand',
        'meta_query' => [
            [
                'key'   => 'type',
                'value' => 'sidebar',
            ]
        ]
    ]);

    $data['banner'] = $banners[0];

    $banner_id = $banners[0]->ID;

    $views = get_post_meta($banner_id, '_banner_views', true);
    $count = ( empty($views) ? 0 : $views );
    $count++;

    update_post_meta($banner_id, '_banner_views', $count);

    $data['views'] = get_post_meta($banner_id, '_banner_views', true);

    return $data;

    return $data;
});
