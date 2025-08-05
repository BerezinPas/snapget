<?php

use Timber\Timber;

$context = Timber::context();

$options = get_fields('options');
$context['options'] = $options;

$breaking_article_id = $options['global_BreakingArticle_breakingArticle'];

$context['related_news'] = Timber::get_posts([
  'post_status' => 'publish',
  'post_type' => 'post',
  'post__not_in' => [ $breaking_article_id ],
  'posts_per_page' => 8,
]);

Timber::render('templates/single-company.twig', $context);
