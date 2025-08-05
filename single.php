<?php

use Timber\Timber;

$context = Timber::context();

$options = get_fields('options');

$breaking_article_id = $options['global_BreakingArticle_breakingArticle'];

$companies = get_fields('companies');
$context['companies'] = $companies;

$post_id = get_queried_object_id();
$post = Timber::get_post($post_id);

$post_tags = $post->terms('post_tag');
$main_tags = $post->meta('main_tags');

if ($main_tags) {
    $tags_ids = array_map(function ($tag) {
        return $tag->id;
    }, $main_tags);
} else {
    $tags_ids = array_map(function ($tag) {
        return $tag->id;
    }, $post_tags);
}

$context['related_news'] = Timber::get_posts([
  'post_status' => 'publish',
  'post_type' => 'post',
  'post__not_in' => [ $breaking_article_id, $post_id ],
  'tag__in' => $tags_ids,
  'posts_per_page' => 8,
]);

Timber::render('templates/single.twig', $context);
