<?php

namespace Flynt\Components\CardArticle;

add_filter('Flynt/addComponentData?name=CardArticle', function ($data) {
    // $post = $data['post'];
    // $post_date = date('M j, Y', strtotime($post->post_date));
    // $date  = explode(" ", $post_date);
    // $months = [
    //   "Jan" => "Январь",
    //   "Feb" => "Февраль",
    //   "Mar" => "Март",
    //   "Apr" => "Апрель",
    //   "May" => "Май",
    //   "Jun" => "Июнь",
    //   "Jul" => "Июль",
    //   "Aug" => "Август",
    //   "Sep" => "Сентябрь",
    //   "Oct" => "Октябрь",
    //   "Nov" => "Ноябрь",
    //   "Dec" => "Декабрь"
    // ];
    // $data['post_date'] = $months[$date[0]] . " " . $date[1] . " " . $date[2];

    return $data;
});
