<?php

use Timber\Timber;

$context = Timber::context();

$options = get_fields('options');

$breaking_id = $options['global_BreakingArticle_breakingArticle'];
$context['breaking_id'] = $breaking_id;

$banner_feed_items = $options['global_BannerFeed_items'];
$context['banners'] = $banner_feed_items;

$term = Timber::get_term(get_queried_object_id());
$term_id = $term->term_id;
$context['term_id'] = $term_id;

$card_articles = Timber::get_posts([
  'post_status' => 'publish',
  'post_type' => 'post',
  'post__not_in' => [ $breaking_id ],
  'tag__in' => $term_id,
  'posts_per_page' => 3,
]);
$context['card_articles'] = $card_articles;

$cards = [];
foreach ($card_articles as $index => $post) {
    $cards[$index] = $post->ID;
}
$context['card_1'] = $cards[0];
$context['card_2'] = $cards[1];
$context['card_3'] = $cards[2];

Timber::render('templates/tag.twig', $context);
