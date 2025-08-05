<?php

use ACFComposer\ACFComposer;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'userComponents',
        'title' => __('User Components', 'flynt'),
        'style' => 'seamless',
        'fields' => [
            [
                'label' => __('Avatar', 'flynt'),
                'name' => 'avatar',
                'type' => 'image',
                'required' => 0,
                'return_format' => 'array',
                'library' => 'uploadedTo',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
                'preview_size' => 'medium',
            ],
            [
                'label' => __('Telegram', 'flynt'),
                'name' => 'telegram',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => 'Ваш ник в Telegram (для эксклюзивных новостей)',
                'prepend' => '',
                'append' => '',
            ],
            [
                'label' => 'Выберите вашу сферу деятельности',
                'name' => 'activity',
                'aria-label' => '',
                'type' => 'checkbox',
                'instructions' => '',
                'required' => 1,
                'choices' => [
                    'logistics' => 'Логистика',
                    'support' => 'Сопровождение',
                    'trade' => 'Торговля',
                    'production' => 'Производство',
                    'investments' => 'Инвестиции',
                    'other' => 'Другое',
                    'certification' => 'Сертификация',
                    'marketing' => 'Маркетинг',
                ],
                'default_value' => [],
                'return_format' => 'value',
                'allow_custom' => 0,
                'layout' => 'vertical',
                'toggle' => 0,
                'save_custom' => 0,
                'custom_choice_button_text' => 'Add new choice',
            ],
            [
                'label' => 'Favourites',
                'name' => 'favourites',
                'aria-label' => '',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'post_type' => [
                    0 => 'post',
                ],
                'post_status' => [
                    0 => 'publish',
                ],
                'taxonomy' => '',
                'filters' => [
                    0 => 'search',
                    1 => 'post_type',
                    2 => 'taxonomy',
                ],
                'return_format' => 'id',
                'min' => '',
                'max' => '',
                'elements' => '',
                'bidirectional' => 0,
                'bidirectional_target' => [
                ],
            ],
            [
                'label' => __('ReferralId', 'flynt'),
                'name' => 'referral_id',
                'type' => 'text',
                'default_value' => '',
                'readonly' => 1,
            ],
            [
                'label' => __('ReferralFrom', 'flynt'),
                'name' => 'referral_from',
                'type' => 'text',
                'default_value' => '',
                'readonly' => 1,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'user_form',
                    'operator' => '==',
                    'value' => 'edit'
                ]
            ],
        ],
    ]);
});
