<?php

namespace Flynt\Components\SearchHeader;

use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=SearchHeader', function ($data) {
    $data['uuid'] = $data['uuid'] ?? wp_generate_uuid4();
    return $data;
});

Options::addTranslatable('SearchHeader', [
    [
        'label' => __('Search Title', 'flynt'),
        'name' => 'searchTitle',
        'type' => 'text',
        'required' => 1,
        'default_value' => __('Search results for:', 'flynt'),

    ],
    [
        'label' => __('Search Placeholder', 'flynt'),
        'name' => 'searchPlaceholder',
        'type' => 'text',
        'required' => 1,
        'default_value' => __('Search …', 'flynt'),

    ],
]);
