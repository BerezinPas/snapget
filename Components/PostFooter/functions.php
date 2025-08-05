<?php

namespace Flynt\Components\PostFooter;

use Flynt\Utils\Options;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=PostFooter', function ($data) {
    $options = get_fields('options');

    $data['options'] = $options;
    $data['socials'] = $options['global_SocialLinks_items'] ?? null;

    $post = get_queried_object();
    $post_date = date('M j, Y', strtotime($post->post_date));
    $date  = explode(" ", $post_date);
    $months = [
        "Jan" => "Январь",
        "Feb" => "Февраль",
        "Mar" => "Март",
        "Apr" => "Апрель",
        "May" => "Май",
        "Jun" => "Июнь",
        "Jul" => "Июль",
        "Aug" => "Август",
        "Sep" => "Сентябрь",
        "Oct" => "Октябрь",
        "Nov" => "Ноябрь",
        "Dec" => "Декабрь"
    ];
    $data['post_date'] = $months[$date[0]] . " " . $date[1] . " " . $date[2];

    return $data;
});

Options::addTranslatable('PostFooter', [
    [
        'label' => __('Author', 'flynt'),
        'name' => 'author',
        'type' => 'text',
        'default_value' => __('Written by', 'flynt')
    ]
]);
