<?php

namespace Flynt\Components\BannerFeed;

add_filter('Flynt/addComponentData?name=BannerFeed', function ($data) {
    $banner_id = $data['banner_id'];

    $views = get_post_meta($banner_id, '_banner_views', true);
    $count = ( empty($views) ? 0 : $views );
    $count++;

    update_post_meta($banner_id, '_banner_views', $count);

    $data['views'] = get_post_meta($banner_id, '_banner_views', true);

    return $data;
});
