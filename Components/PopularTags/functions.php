<?php

namespace Flynt\Components\PopularTags;

use Timber\Timber;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=PopularTags', function ($data) {
    $tag_video = get_term_by('slug', 'video', 'post_tag');
    $tag_video_id = $tag_video->term_id;

    $data['tags'] =  Timber::get_terms([
    'taxonomy'   => 'post_tag',
    'orderby'    => 'count',
    'order'      => 'DESC',
    'hide_empty' => true,
    'exclude' => [$tag_video_id],
    ]);

    $data['term'] = Timber::get_term();

    return $data;
});

Options::addTranslatable('PopularTags', [
    [
        'label' => __('Title', 'flynt'),
        'name' => 'title',
        'type' => 'text',
        'default_value' => __('Popular tags', 'flynt'),
        'required' => 1,
    ],
]);
