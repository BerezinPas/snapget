<?php

namespace Flynt\Components\SearchResults;

use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=SearchResults', function ($data) {
    $data['uuid'] = $data['uuid'] ?? wp_generate_uuid4();
    return $data;
});

Options::addTranslatable('SearchResults', [
    [
        'label' => __('No Results', 'flynt'),
        'name' => 'no_results',
        'type' => 'text',
        'required' => 1,
        'default_value' => __('No results were found for your request.', 'flynt'),

    ],
    [
        'label' => __('Load More', 'flynt'),
        'name' => 'load_more',
        'type' => 'text',
        'required' => 1,
        'default_value' => __('Load More', 'flynt'),
    ],
]);
