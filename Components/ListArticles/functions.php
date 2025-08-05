<?php

namespace Flynt\Components\ListArticles;

use Timber\Timber;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=ListArticles', function ($data) {
    $data['paged'] = get_query_var('paged', 1);
    $data['banners'] = Timber::get_posts([
        'post_status' => 'publish',
        'post_type' => 'banner',
        'orderby' => 'rand',
        'meta_query' => [
            [
                'key'   => 'type',
                'value' => 'feed',
            ]
        ]
    ]);

    return $data;
});

Options::addTranslatable('ListArticles', [
    [
        'label' => __('Load More', 'flynt'),
        'name' => 'load_more',
        'type' => 'text',
        'required' => 1,
        'default_value' => __('Load More', 'flynt'),
    ],
]);
