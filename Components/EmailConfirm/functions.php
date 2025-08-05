<?php

namespace Flynt\Components\EmailConfirm;

use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=EmailConfirm', function ($data) {

    return $data;
});


Options::addTranslatable('EmailConfirm', [
    [
        'label' => __('Title', 'flynt'),
        'name' => 'title',
        'type' => 'text',
        'default_value' => __('E-mail confirmed!', 'flynt')
    ],
    [
        'label' => __('Text', 'flynt'),
        'name' => 'text',
        'type' => 'text',
        'default_value' => __('Thank you for registering', 'flynt')
    ],
    [
        'label' => __('Login', 'flynt'),
        'name' => 'login',
        'type' => 'text',
        'default_value' => __('Login', 'flynt')
    ],
]);
