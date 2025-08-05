<?php

namespace Flynt\Components\LeadArticle;

use Flynt\Utils\Options;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=LeadArticle', function ($data) {
    // $options = get_fields('options');
    // $post_id = $options['global_LeadArticle_leadArticle'];

    // $data['post'] = Timber::get_post($post_id);

    // $post = $data['post'];
    // $post_date = date('M j, Y', strtotime($post->post_date));
    // $date  = explode(" ", $post_date);
    // $months = [
    //     "Jan" => "Январь",
    //     "Feb" => "Февраль",
    //     "Mar" => "Март",
    //     "Apr" => "Апрель",
    //     "May" => "Май",
    //     "Jun" => "Июнь",
    //     "Jul" => "Июль",
    //     "Aug" => "Август",
    //     "Sep" => "Сентябрь",
    //     "Oct" => "Октябрь",
    //     "Nov" => "Ноябрь",
    //     "Dec" => "Декабрь"
    // ];
    // $data['post_date'] = $months[$date[0]] . " " . $date[1] . " " . $date[2];

    return $data;
});

Options::addGlobal('LeadArticle', [
  [
      'label' => __('Lead Article', 'flynt'),
      'name' => 'leadArticle',
      'type' => 'post_object',
      'post_type' => [
          'post'
      ],
      'allow_null' => 1,
      'multiple' => 0,
      'ui' => 1,
      'required' => 1,
      'return_format' => 'id',
  ],
]);
