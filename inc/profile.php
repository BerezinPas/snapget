<?php

namespace Flynt\Profile;

// Save referral to cookie
add_action('init', function () {
    if (!isset($_COOKIE['referral']) && isset($_GET['referral'])) {
        setcookie('referral', $_GET['referral']);
    }
});


// Update registration user fields
add_action('user_register', function ($user_id) {
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
    $referralId = substr(str_shuffle($str_result), 0, 9);

    update_user_meta($user_id, 'referral_id', $referralId);

    if (isset($_COOKIE["referral"])) {
        update_user_meta($user_id, 'referral_from', $_COOKIE["referral"]);
    }
}, 10, 1);


// Complete registration redirects
add_action('template_redirect', function () {
    $user_id = get_current_user_id();
    $telegram = get_field('telegram', 'user_' . $user_id);

    if (is_page('profile') && is_user_logged_in() && $telegram == '') {
        wp_redirect(home_url('/complete-registration/'));
        exit();
    }

    if (is_page('complete-registration') && is_user_logged_in() && $telegram !== '') {
        wp_redirect(home_url('/profile/'));
        exit();
    }
});
