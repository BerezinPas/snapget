<?php

namespace Flynt\Components\PostHeader;

use Flynt\Utils\Options;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=PostHeader', function ($data) {
    // Translate RU dates
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

    // Calculate reading time
    function get_reading_time(string $content = null)
    {

        return ceil(str_word_count(strip_tags($content)) / 250);
    }

    // Fix RU plural endings
    function ru_plural($number, $titles = [/*1*/'комментарий', /*2*/'комментария', /*5*/'комментариев'])
    {
        $cases =  [2, 0, 1, 1, 1, 2];

        return $number . ' ' . $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }

    $total_views = do_shortcode('[WPPV-TOTAL-VIEWS]');
    $reading_time = get_reading_time($post->post_content);

    $data['views'] = ru_plural($total_views, [$data['views_single'], $data['views_double'], $data['views_multiple']]);
    $data['minutes'] = ru_plural($reading_time, [$data['minutes_single'], $data['minutes_double'], $data['minutes_multiple']]);

    return $data;
});

Options::addTranslatable('PostHeader', [
    [
        'label' => __('Views Single', 'flynt'),
        'name' => 'views_single',
        'type' => 'text',
        'default_value' => __('views', 'flynt')
    ],
    [
        'label' => __('Views Double', 'flynt'),
        'name' => 'views_double',
        'type' => 'text',
        'default_value' => __('views', 'flynt')
    ],
    [
        'label' => __('Views Multiple', 'flynt'),
        'name' => 'views_multiple',
        'type' => 'text',
        'default_value' => __('views', 'flynt')
    ],
    [
        'label' => __('Minutes Single', 'flynt'),
        'name' => 'minutes_single',
        'type' => 'text',
        'default_value' => __('minutes', 'flynt')
    ],
    [
        'label' => __('Minutes Double', 'flynt'),
        'name' => 'minutes_double',
        'type' => 'text',
        'default_value' => __('minutes', 'flynt')
    ],
    [
        'label' => __('Minutes Multiple', 'flynt'),
        'name' => 'minutes_multiple',
        'type' => 'text',
        'default_value' => __('minutes', 'flynt')
    ],
    [
        'label' => __('Share', 'flynt'),
        'name' => 'share',
        'type' => 'text',
        'default_value' => __('Share', 'flynt')
    ],
    [
        'label' => __('Add to Favorite', 'flynt'),
        'name' => 'favourites',
        'type' => 'text',
        'default_value' => __('Add to Favorite', 'flynt')
    ],
]);
