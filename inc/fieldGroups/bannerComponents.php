<?php

use ACFComposer\ACFComposer;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'bannerComponents',
        'title' => __('Banner Components', 'flynt'),
        'style' => 'default',
        'fields' => [
          [
            'label' => __('Type', 'flynt'),
            'name' => 'type',
            'type' => 'button_group',
            'instructions' => '',
            'required' => 0,
            'wrapper' => [
              'width' => '20',
            ],
            'choices' => [
              'feed' => 'Feed',
              'sidebar' => 'Sidebar',
            ],
            'default_value' => '',
            'return_format' => 'value',
            'allow_null' => 0,
            'layout' => 'horizontal',
          ],
          [
            'label' => __('Link', 'flynt'),
            'name' => 'link',
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
            'wrapper' => [
              'width' => '80',
            ],
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
          ],
          [
            'label' => __('Image 1028 x 284', 'flynt'),
            'name' => 'image_1028',
            'type' => 'image',
            'instructions' => '',
            'required' => 1,
            'return_format' => 'array',
            'preview_size' => 'full',
            'library' => 'all',
            'min_width' => '1028',
            'min_height' => '284',
            'min_size' => '',
            'max_width' => '1028',
            'max_height' => '284',
            'max_size' => '',
            'mime_types' => '',
            'conditional_logic' => [
              [
                [
                    'fieldPath' => 'type',
                    'operator' => '==',
                    'value' => 'feed'
                ]
              ]
            ],
          ],
          [
            'label' => __('Image 902 x 249', 'flynt'),
            'name' => 'image_902',
            'type' => 'image',
            'instructions' => '',
            'required' => 1,
            'return_format' => 'array',
            'preview_size' => 'full',
            'library' => 'all',
            'min_width' => '902',
            'min_height' => '249',
            'min_size' => '',
            'max_width' => '902',
            'max_height' => '249',
            'max_size' => '',
            'mime_types' => '',
            'conditional_logic' => [
              [
                [
                    'fieldPath' => 'type',
                    'operator' => '==',
                    'value' => 'feed'
                ]
              ]
            ],
          ],
          [
            'label' => __('Image 688 x 190', 'flynt'),
            'name' => 'image_688',
            'type' => 'image',
            'instructions' => '',
            'required' => 1,
            'return_format' => 'array',
            'preview_size' => 'full',
            'library' => 'all',
            'min_width' => '688',
            'min_height' => '190',
            'min_size' => '',
            'max_width' => '688',
            'max_height' => '190',
            'max_size' => '',
            'mime_types' => '',
            'conditional_logic' => [
              [
                [
                    'fieldPath' => 'type',
                    'operator' => '==',
                    'value' => 'feed'
                ]
              ]
            ],
          ],
          [
            'label' => __('Image 308 x 332', 'flynt'),
            'name' => 'image_308',
            'type' => 'image',
            'instructions' => '',
            'required' => 1,
            'return_format' => 'array',
            'preview_size' => 'full',
            'library' => 'all',
            'min_width' => '308',
            'min_height' => '332',
            'min_size' => '',
            'max_width' => '308',
            'max_height' => '332',
            'max_size' => '',
            'mime_types' => '',
            // 'conditional_logic' => [
            //   [
            //     [
            //         'fieldPath' => 'type',
            //         'operator' => '==',
            //         'value' => 'sidebar'
            //     ]
            //   ]
            // ],
          ],
          [
            'label' => __('Image 280 x 301', 'flynt'),
            'name' => 'image_280',
            'type' => 'image',
            'instructions' => '',
            'required' => 1,
            'return_format' => 'array',
            'preview_size' => 'full',
            'library' => 'all',
            'min_width' => '280',
            'min_height' => '301',
            'min_size' => '',
            'max_width' => '280',
            'max_height' => '301',
            'max_size' => '',
            'mime_types' => '',
            'conditional_logic' => [
              [
                [
                    'fieldPath' => 'type',
                    'operator' => '==',
                    'value' => 'sidebar'
                ]
              ]
            ],
          ],
          [
            'label' => __('Image 266 x 286', 'flynt'),
            'name' => 'image_266',
            'type' => 'image',
            'instructions' => '',
            'required' => 1,
            'return_format' => 'array',
            'preview_size' => 'full',
            'library' => 'all',
            'min_width' => '266',
            'min_height' => '286',
            'min_size' => '',
            'max_width' => '266',
            'max_height' => '286',
            'max_size' => '',
            'mime_types' => '',
            'conditional_logic' => [
              [
                [
                    'fieldPath' => 'type',
                    'operator' => '==',
                    'value' => 'sidebar'
                ]
              ]
            ],
          ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'banner'
                ]
            ],
        ],
    ]);
});
