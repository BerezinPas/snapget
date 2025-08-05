<?php

namespace Flynt\Components\UserProfile;

use Flynt\Utils\Options;
use Timber\Timber;

function getACFLayout()
{
    return [
        'name' => 'UserProfile',
        'label' => __('Block: UserProfile', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'delay' => 0,
                'media_upload' => 0,
                'required' => 1,
            ],
        ]
    ];
}

add_filter('Flynt/addComponentData?name=UserProfile', function ($data) {
    $user_id = get_current_user_id();

    $referralId = get_field('referral_id', 'user_' . $user_id);

    $data['referralId'] = $referralId;

    // $test = get_post_meta($user_id, 'userComponents_favourites', true);
    // $test = acf_get_fields();
    // $test = get_field('favourites', $user_id);

    // $data['test'] = $test;
    // var_dump(get_field_objects($user_id));

    return $data;
});

Options::addTranslatable('UserProfile', [
    [
        'label' => __('User Profile', 'flynt'),
        'name' => 'user_profile',
        'type' => 'text',
        'default_value' => __('User Profile', 'flynt')
    ],
    [
        'label' => __('Favourites', 'flynt'),
        'name' => 'favourites',
        'type' => 'text',
        'default_value' => __('Favourites', 'flynt')
    ],
    [
        'label' => __('Support', 'flynt'),
        'name' => 'support',
        'type' => 'text',
        'default_value' => __('Support', 'flynt')
    ],
    [
        'label' => __('Logout', 'flynt'),
        'name' => 'logout',
        'type' => 'text',
        'default_value' => __('Logout', 'flynt')
    ],
]);
