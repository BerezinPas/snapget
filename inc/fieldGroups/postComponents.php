<?php

use ACFComposer\ACFComposer;


add_action('Flynt/afterRegisterComponents', function () {
    // Получаем все формы CF7 для выпадающего списка
    $cf7_forms = get_posts([
        'post_type' => 'wpcf7_contact_form',
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ]);
    
    $form_choices = [];
    foreach ($cf7_forms as $form) {
        $form_choices[$form->ID] = $form->post_title;
    }

    
    ACFComposer::registerFieldGroup([
        'name' => 'postComponents',
        'title' => __('Post Components', 'flynt'),
        'style' => 'seamless',
        'fields' => [
            [
                'label' => 'Main Tags',
                'name' => 'main_tags',
                'type' => 'taxonomy',
                'taxonomy' => 'post_tag',
                'instructions' => 'Maximum: 2',
                'add_term' => 0,
                'save_terms' => 0,
                'load_terms' => 0,
                'return_format' => 'object',
                'field_type' => 'multi_select',
                'allow_null' => 0,
                'bidirectional' => 0,
                'multiple' => 0,
                'required' => 0,
                'bidirectional_target' => [
                ],
            ],
            [
                'label' => 'Companies',
                'name' => 'companies',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'post_type' => [
                    0 => 'company',
                ],
                'post_status' => '',
                'taxonomy' => '',
                'filters' => [
                    0 => 'search',
                ],
                'return_format' => 'object',
                'min' => '',
                'max' => '',
                'elements' => '',
                'bidirectional' => 0,
                'bidirectional_target' => [
                ],
            ],
            [
                'label' => 'Добавить файлы для скачивания',
                'name' => 'download_files',
                'type' => 'repeater',
                'button_label' => 'Добавить файл',
                'sub_fields' => [
                    [
                        'label' => 'Название файла',
                        'name' => 'file_name',
                        'type' => 'text',
                        'instructions' => 'Можете переименовать файл, если не надо оставьте поле пустым',
                        'required' => 0
                    ],
                    [
                        'label' => 'Файл',
                        'name' => 'file',
                        'type' => 'file',
                        'return_format' => 'array',
                        'library' => 'all',
                        'required' => 1
                    ]
                ]
            ],
            // форма обратной связи
             [
                'label' => 'Показать форму обратной связи"',
                'name' => 'enable_request_consultation',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1,
                'wrapper' => [
                    'width' => '50%'
                ],
                'instructions' => 'Отображает форму справа от контента'
            ],
            [
                'label' => 'Выберите форму',
                'name' => 'cf7_form_id',
                'type' => 'select',
                'choices' => $form_choices,
                'conditional_logic' => [
                    [
                        [
                            'field' => 'enable_request_consultation',
                            'operator' => '==',
                            'value' => '1'
                        ]
                    ]
                ]
            ],
            [
                'label' => 'Выберите стикер',
                'name' => 'sticker_type',
                'type' => 'select',
                'choices' => [
                    'empty' => 'не отображать',
                    'pro' => 'Pro',
                    'expert' => 'Expert',
                ],
                'default_value' => 'empty',
                
            ],
            
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post'
                ]
            ],
        ],
    ]);
});
