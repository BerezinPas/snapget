<?php

namespace Flynt\Components\BreakingArticle;

use Flynt\Utils\Options;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=BreakingArticle', function ($data) {
    $options = get_fields('options');
    $post_id = $options['global_BreakingArticle_breakingArticle'];

    $data['post'] = !empty($post_id) ? Timber::get_post($post_id) : null;

    return $data;
});

Options::addGlobal('BreakingArticle', [
    [
        'label' => __('Breaking Article', 'flynt'),
        'name' => 'breakingArticle',
        'type' => 'post_object',
        'post_type' => [
            'post'
        ],
        'allow_null' => 1,
        'multiple' => 0,
        'ui' => 1,
        'required' => 0,
        'return_format' => 'id',
    ],
]);

Options::addTranslatable('BreakingArticle', [
    [
        'label' => __('Tag', 'flynt'),
        'name' => 'tag',
        'type' => 'text',
        'default_value' => __('LIVE', 'flynt'),
        'required' => 1,
        'wrapper' => [
            'width' => 50
        ],
    ],
    [
        'label' => __('Button', 'flynt'),
        'name' => 'button',
        'type' => 'text',
        'default_value' => __('See more', 'flynt'),
        'required' => 1,
        'wrapper' => [
            'width' => 50
        ],
    ],
]);
