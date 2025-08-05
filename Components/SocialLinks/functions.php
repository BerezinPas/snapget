<?php

namespace Flynt\Components\SocialLinks;

use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=SocialLinks', function ($data) {
    $options = get_fields('options');

    $data['options'] = $options;

    $data['title'] = $options['global_SocialLinks_title'] ?? null;
    $data['text'] = $options['global_SocialLinks_text'] ?? null;
    $data['items'] = $options['global_SocialLinks_items'] ?? null;

    return $data;
});

Options::addGlobal('SocialLinks', [
  [
    'label' => __('Title', 'flynt'),
    'name' => 'title',
    'type' => 'text',
    'default_value' => __('Subscribe to Snap&Get', 'flynt'),
    'wrapper' => [
        'width' => '50',
    ],
  ],
  [
    'label' => __('Text', 'flynt'),
    'name' => 'text',
    'type' => 'textarea',
    'default_value' => __('Read the news wherever it is convenient for you on our social networks', 'flynt'),
    'wrapper' => [
        'width' => '50',
    ],
  ],
  [
    'label' => __('Items', 'flynt'),
    'name' => 'items',
    'type' => 'repeater',
    'collapsed' => '',
    'layout' => 'block',
    'button_label' => __('Add Item', 'flynt'),
    'sub_fields' => [
        [
          'label' => __('Icon', 'flynt'),
          'name' => 'icon',
          'type' => 'select',
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 0,
          'ajax' => 0,
          'choices' => [
              'telegram' => __('Telegram', 'flynt'),
              'vk' => __('VK', 'flynt'),
              'youtube' => __('YouTube', 'flynt'),
              'x' => __('X', 'flynt'),
          ],
          'default_value' => '',
          'wrapper' => [
            'width' => 50
          ],
        ],
        [
            'label' => __('Link', 'flynt'),
            'name' => 'link',
            'type' => 'text',
            'required' => 1,
            'wrapper' => [
              'width' => 50
            ],
        ],
    ]
  ],
]);
