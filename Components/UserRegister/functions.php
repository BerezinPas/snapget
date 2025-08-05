<?php

namespace Flynt\Components\UserRegister;

use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=UserRegister', function ($data) {

    return $data;
});

Options::addTranslatable('UserRegister', [
    [
        'label' => __('Banner', 'flynt'),
        'name' => 'banner',
        'type' => 'image',
        'instructions' => __('Image-Format: JPG, PNG, SVG, WebP.', 'flynt'),
        'preview_size' => 'medium',
        'mime_types' => 'jpg,jpeg,png,svg,webp',
        'required' => 1,
    ],
]);
