<?php

use ACFComposer\ACFComposer;
use Flynt\Components;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'textComponents',
        'title' => __('Text Components', 'flynt'),
        'style' => 'seamless',
        'fields' => [
            [
                'label' => 'Content',
                'name' => 'content',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 1,
                'default_value' => '',
                'tabs' => 'visual',
                'toolbar' => 'default',
                'media_upload' => 0,
                'delay' => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-text.php'
                ]
            ],
        ],
    ]);
});
