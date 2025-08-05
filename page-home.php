<?php

use Timber\Timber;

global $paged;

if (!isset($paged) || !$paged) {
    $paged = 1;
}

$context = Timber::context();

$options = get_fields('options');

$breaking_article_id = $options['global_BreakingArticle_breakingArticle'];
$lead_article_id     = $options['global_LeadArticle_leadArticle'];
$banner_feed_image   = $options['global_BannerFeed_image'];
$banner_feed_items   = $options['global_BannerFeed_items'];

$tag_video = get_term_by('slug', 'video', 'post_tag');
$tag_video_id = $tag_video->term_id;

$context['banner_feed_image'] = $banner_feed_image;
$context['banners'] = $banner_feed_items;

$context['lead_article'] = Timber::get_post($lead_article_id);

$context['card_articles'] = Timber::get_posts([
  'post_status' => 'publish',
  'post_type' => 'post',
  'post__not_in' => [ $breaking_article_id, $lead_article_id ],
  'posts_per_page' => 3,
]);

$context['list_articles'] = Timber::get_posts([
  'post_status' => 'publish',
  'post_type' => 'post',
  'post__not_in' => [ $breaking_article_id, $lead_article_id ],
  'posts_per_page' => 5,
  'offset'         => 3,
  'paged'  => $paged,
]);

$context['video_articles'] = Timber::get_posts([
  'post_status' => 'publish',
  'post_type' => 'post',
  'post__not_in' => [ $breaking_article_id, $lead_article_id ],
  'tag__in' => $tag_video_id,
  'posts_per_page' => 3,
]);

$context['test'] = $lead_article_id;

Timber::render('templates/page-home.twig', $context);
