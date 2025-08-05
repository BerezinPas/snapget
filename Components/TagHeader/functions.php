<?php

namespace Flynt\Components\TagHeader;

use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=TagHeader', function ($data) {
    $options = get_fields('options');

    $data['options'] = $options;
    $data['button'] = $options['global_TagHeader_button'];

    return $data;
});

Options::addTranslatable('TagHeader', [
    [
        'label' => __('Button', 'flynt'),
        'name' => 'back',
        'type' => 'text',
        'default_value' => __('Back to main page', 'flynt'),
        'required' => 1,
    ],
]);
