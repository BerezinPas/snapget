<?php

namespace Flynt\Components\Error404;

use Flynt\Utils\Options;

Options::addTranslatable('Error404', [
    [
        'label' => __('Text', 'flynt'),
        'name' => 'text',
        'type' => 'wysiwyg',
        'delay' => 0,
        'media_upload' => 0,
        'required' => 1,
        'default_value' => sprintf('<h1>%1$s</h1><p>%2$s</p>', __('Error 404', 'flynt'), __('Unfortunately, the requested page was not found. You may have followed a link in which there was an error, or the resource was deleted.', 'flynt')),
    ],
    [
        'label' => __('Button', 'flynt'),
        'name' => 'button',
        'type' => 'text',
        'default_value' => __('Go to Main page', 'flynt')
    ]
]);
