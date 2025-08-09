<?php

// namespace Flynt\Components\CommentSection;

use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=CommentSection', function ($data) {
    $postId = get_the_ID();
    $data['post'] = \Timber\Timber::get_post($postId);

    $data['comments'] = get_comments([
        'post_id' => $postId,
        'status' => 'approve',
        'order' => 'ASC',
        'hierarchical' => 'threaded'
    ]);

    $data['options'] = Options::getTranslatable('CommentSection');
    return $data;
});

// Кастомный фильтр для аватарок из ACF
add_filter('get_avatar', function($avatar_html, $id_or_email, $size, $default, $alt, $args) {
    // Пропускаем гостевые комментарии
    if ($id_or_email instanceof WP_Comment && !$id_or_email->user_id) {
        return $avatar_html;
    }

    $user_id = is_numeric($id_or_email)
        ? $id_or_email
        : email_exists($id_or_email);

    if ($user_id) {
        $avatar_data = get_field('avatar', 'user_' . $user_id);

        // Обработка разных форматов ACF
        $avatar_url = is_array($avatar_data)
            ? ($avatar_data['url'] ?? '')
            : $avatar_data;

        if ($avatar_url) {
            $class = $args['class'] ?? 'comment-avatar-img';
            return sprintf(
                '<img src="%s" width="%d" height="%d" alt="%s" class="%s" />',
                esc_url($avatar_url),
                (int)$size,
                (int)$size,
                esc_attr($alt),
                esc_attr($class)
            );
        }
    }

    return $avatar_html;
}, 10, 6);

add_filter('comment_form_defaults', function ($fields) {
    $fields['title_reply'] = '';
    $fields['class_container'] = 'commentForm';
    $fields['comment_field'] = '<textarea name="comment" class="commentForm-textarea" placeholder="Ваш комментарий..." required></textarea>';
    $fields['submit_button'] = '<button type="submit" class="commentForm-submit">Отправить</button>';
    return $fields;
});

Options::addTranslatable('CommentSection', [
    [
        'label' => 'Настройки комментариев',
        'name' => 'commentSettings',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Текст кнопки "Ответить"',
                'name' => 'replyText',
                'type' => 'text',
                'default_value' => 'Ответить'
            ],
            [
                'label' => 'Текст заголовка формы',
                'name' => 'formTitle',
                'type' => 'text',
                'default_value' => 'Оставить комментарий'
            ]
        ]
    ]
]);
