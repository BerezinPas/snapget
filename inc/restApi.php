<?php

namespace Flynt\RestApi;

add_action('rest_api_init', function () {
    register_rest_route('api', '/favourites', [
      'methods' => 'POST',
      'permission_callback' => '__return_true',
      'callback' => function ($request) {
        $params = $request->get_params();
        $user_id = $params['user_id'];
        $post_id = $params['post_id'];

        $favourites = get_field('favourites', 'user_' . $user_id);

        if (in_array($post_id, $favourites)) {
            $favourites = array_diff($favourites, [$post_id]);
            $result = false;
        } else {
            array_push($favourites, $post_id);
            $result = true;
        }

        update_field('favourites', $favourites, 'user_' . $user_id);

        return $result;
      },
    ]);
});

add_action('rest_api_init', function () {
    register_rest_route('api', '/user', [
        'methods' => 'GET',
        'permission_callback' => '__return_true',
        'callback' => function ($request) {
            $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
            $post_id = isset($_GET['post_id']) ? $_GET['post_id'] : '';

            $favourites = get_field('favourites', 'user_' . $user_id);

            if (in_array($post_id, $favourites)) {
                return true;
            } else {
                return false;
            }
        },
    ]);
});
