<?php

namespace Flynt\Components\PostSticker;

add_filter('Flynt/addComponentData?name=PostSticker', function ($data) {
    // Получаем ID текущего поста
    $post_id = $data['post']->ID ?? get_the_ID();
    
    // Получаем значение поля из ACF
    $sticker_type = get_field('sticker_type', $post_id) ?: 'empty';
    
    // Обрабатываем выбор
    if ($sticker_type === 'empty') {
        $data['sticker'] = '';
        return $data;
    }

    $textMap = [
        'pro' => 'Pro',
        'expert' => 'Expert'
    ];
    

    $data['sticker_type'] = $sticker_type;

    $text = $textMap[$sticker_type] ?? 'Pro';
    $data['sticker'] = implode('', array_map(function($char) {
        return "<span class='char'>{$char}</span>";
    }, str_split($text)));
    
    return $data;
});
