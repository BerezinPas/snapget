<?php

use Timber\Timber;
use Timber\PostQuery;

$context = Timber::context();

$options = get_fields('options');

$breaking_id = $options['global_BreakingArticle_breakingArticle'];
$context['breaking_id'] = $breaking_id;

$lead_id = $options['global_LeadArticle_leadArticle'];
$context['lead_id'] = $lead_id;
$context['lead_article'] = Timber::get_post($lead_id);

$tag_video = get_term_by('slug', 'video', 'post_tag');
$tag_video_id = $tag_video->term_id;
$video_articles = Timber::get_posts([
  'post_status' => 'publish',
  'post_type' => 'post',
  'post__not_in' => [ $breaking_id, $lead_id ],
  'tag__in' => $tag_video_id,
  'posts_per_page' => 3,
]);
$context['video_articles'] = $video_articles;

$card_articles = Timber::get_posts([
  'post_status' => 'publish',
  'post_type' => 'post',
  'post__not_in' => [ $breaking_id, $lead_id ],
  'tag__not_in' => [ $tag_video_id ],
  'posts_per_page' => 3,
]);
$context['card_articles'] = $card_articles;

Timber::render('templates/index.twig', $context);
