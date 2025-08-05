<?php

namespace Flynt\Components\VideoNews;

use Timber\Timber;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=VideoNews', function ($data) {
    $options = get_fields('options');

    $breaking_article_id = $options['global_BreakingArticle_breakingArticle'];
    $lead_article_id     = $options['global_LeadArticle_leadArticle'];

    $tag_video = get_term_by('slug', 'video', 'post_tag');
    $tag_video_id = $tag_video->term_id;

    $data['posts'] = Timber::get_posts([
      'post_status' => 'publish',
      'post_type' => 'post',
      'post__not_in' => [ $breaking_article_id, $lead_article_id ],
      'tag__in' => $tag_video_id,
      'posts_per_page' => 3,
    ]);

    $data['term'] = Timber::get_term($tag_video_id);

    return $data;
});

Options::addTranslatable('VideoNews', [
  [
      'label' => __('Button', 'flynt'),
      'name' => 'button',
      'type' => 'text',
      'default_value' => __('All Videos', 'flynt'),
      'required' => 1,
  ],
]);
