<?php

use Timber\Timber;
use Timber\​Pagination;

$context = Timber::context();

$options = get_fields('options');

$breaking_id = $options['global_BreakingArticle_breakingArticle'];
$context['breaking_id'] = $breaking_id;

$banner_feed_items = $options['global_BannerFeed_items'];
$context['banners'] = $banner_feed_items;

Timber::render('templates/tag-video.twig', $context);
