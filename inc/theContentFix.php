<?php

namespace Flynt\TheContentFix;

use Timber\Timber;

add_filter('wp_insert_post_data', function ($data, $postArr) {
    if (
        in_array(
            $postArr['post_type'],
            [
                'revision',
                'nav_menu_item',
                'attachment',
                'customize_changeset',
                'custom_css',
            ]
        )
    ) {
        return $data;
    }

    $isPostTypeUsingGutenberg = post_type_supports($data['post_type'], 'editor');
    if (!$isPostTypeUsingGutenberg) {
        // Check if no content was saved before, or if there is a flyntTheContent shortcode but the id does not match the post id.
        if (empty($data['post_content']) || isShortcodeAndDoesNotMatchId($data['post_content'], $postArr['ID'])) {
            $data['post_content'] = "[flyntTheContent id=\"{$postArr['ID']}\"]";
        }
    }

    return $data;
}, 99, 2);

add_shortcode('flyntTheContent', function ($attrs) {
    if (is_admin()) {
        return;
    }

    $postId = $attrs['id'];
    // in case the post id was not set correctly and is 0
    if (!empty($postId)) {
        $context = Timber::context();
        $context['post'] = Timber::get_Post($postId);
        $context['post']->setup();
        return Timber::compile('templates/theContentFix.twig', $context);
    }
});

function isShortcodeAndDoesNotMatchId($postContent, $postId)
{
    preg_match('/^\[flyntTheContent id=\\\"(\d*)\\\"\]$/', $postContent, $matches);
    if (!empty($matches) && $matches[1] != $postId) {
        return true;
    } else {
        return false;
    }
}


// Add custom image sizes
add_image_size('post-large', 1028, 0);
add_image_size('post-desktop', 902, 0);
add_image_size('post-tablet', 688, 0);
add_image_size('post-mobile', 688, 0);

add_image_size('lead-large', 514, 364);
add_image_size('lead-desktop', 451, 364);
add_image_size('lead-tablet', 688, 340);
add_image_size('lead-mobile', 688, 340);

add_image_size('card-large', 332, 0);
add_image_size('card-desktop', 290, 0);
add_image_size('card-tablet', 219, 0);
add_image_size('card-mobile', 688, 0);

add_image_size('list-large', 176, 116);
add_image_size('list-desktop', 176, 116);
add_image_size('list-tablet', 176, 140);
add_image_size('list-mobile', 688, 0);

add_image_size('video-large', 332, 0);
add_image_size('video-desktop', 290, 0);
add_image_size('video-tablet', 336, 0);
add_image_size('video-mobile', 688, 0);

add_image_size('sidebar-large', 252, 164);
add_image_size('sidebar-desktop', 210, 164);
add_image_size('sidebar-tablet', 688, 0);
add_image_size('sidebar-mobile', 252, 0);


// Config WP Queries
function cutUrl($string, $delimiter, $count)
{
    $parts = explode($delimiter, $string);
    $result = implode($delimiter, array_slice($parts, -2, $count));

    return $result;
}

$breaking_id = get_field('global_BreakingArticle_breakingArticle', 'option');
$lead_id = get_field('global_LeadArticle_leadArticle', 'option');
$video_id = get_term_by('slug', 'video', 'post_tag')->term_id;
$url = wp_parse_url($_SERVER['REQUEST_URI']);

global $cards;
$cards = get_posts([
    'post_status' => 'publish',
    'post_type' => 'post',
    'posts_per_page' => 3,
    'post__not_in' => [ $breaking_id, $lead_id ],
    'tag__not_in' => [ $video_id ],
]);

if (str_contains($url['path'], 'tag')) {
    $url_parts = explode('/', $url['path']);
    $tag_slug = $url_parts[3];
    $tag_object = get_term_by('slug', $tag_slug, 'post_tag');
    $tag_id = $tag_object->term_id;
    $cards = get_posts([
        'post_status' => 'publish',
        'post_type' => 'post',
        'posts_per_page' => 3,
        'post__not_in' => [ $breaking_id ],
        'tag__in' => [ $tag_id ],
    ]);
}

add_action('pre_get_posts', function ($query) {
    global $cards;
    $breaking_id = get_field('global_BreakingArticle_breakingArticle', 'option');
    $lead_id = get_field('global_LeadArticle_leadArticle', 'option');
    $video_id = get_term_by('slug', 'video', 'post_tag')->term_id;

    if ($query->is_main_query() && ! is_admin()) {
        if ($query->is_home()) {
            $query->set('posts_per_page', 5);
            $query->set('post__not_in', [(int)$breaking_id, (int)$lead_id, (int)$cards[0]->ID, (int)$cards[1]->ID, (int)$cards[2]->ID]);
            $query->set('tag__not_in', [(int)$video_id]);
        }

        if ($query->is_tag()) {
            $query->set('posts_per_page', 5);
            $query->set('post__not_in', [(int)$breaking_id, (int)$cards[0]->ID, (int)$cards[1]->ID, (int)$cards[2]->ID]);
        }

        if (is_tag('video')) {
            $query->set('posts_per_page', 18);
        }

        if ($query->is_search()) {
            $query->set('posts_per_page', 5);
            $query->set('post_type', [ 'post']);
        }
    }
});


// Setup Banner views
add_action('add_meta_boxes_banner', function () {
    add_meta_box(
        'banner-views',
        __('Banner Views', 'flynt'),
        function ($post) {

            // Add a nonce field so we can check for it later.
            wp_nonce_field('banner_views_nonce', 'banner_views_nonce');

            $value = get_post_meta($post->ID, '_banner_views', true);

            echo '<textarea style="width:100%" id="banner_views" name="banner_views" disabled>' . esc_attr($value) . '</textarea>';
        }
    );
});

add_action('save_post', function ($post_id) {

    // Check if our nonce is set.
    if (! isset($_POST['banner_views_nonce'])) {
        return;
    }

    // Verify that the nonce is valid.
    if (! wp_verify_nonce($_POST['banner_views_nonce'], 'banner_views_nonce')) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (! current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (! current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if (! isset($_POST['banner_views'])) {
        return;
    }

    // Set NULL for draft status
    if ($_POST['post_status'] === 'draft') {
        $my_data = 0;
    } else {
        // Sanitize user input.
        $my_data = sanitize_text_field($_POST['banner_views']);
    }

    // Update the meta field in the database.
    update_post_meta($post_id, '_banner_views', $my_data);
});


// Add Banner Views to post list columns
add_filter('manage_banner_posts_columns', function ($columns) {
    return array_merge($columns, ['banner_views' => __('Views', 'textdomain')]);
});

add_action('manage_banner_posts_custom_column', function ($column_key, $post_id) {
    if ($column_key == 'banner_views') {
        $banner_views = esc_attr(get_post_meta($post_id, '_banner_views', true));
        if ($banner_views) {
            echo $banner_views;
        }
    }
}, 10, 2);
