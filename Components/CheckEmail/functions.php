<?php

namespace Flynt\Components\CheckEmail;

add_filter('Flynt/addComponentData?name=CheckEmail', function ($data) {
    // Параметры из URL
    $data['is_password_reset'] = isset($_GET['password_reset']);
    $data['resent'] = isset($_GET['resent']);
    $data['resend_error'] = isset($_GET['resend_error']);
    $data['already_activated'] = isset($_GET['already_activated']);
    $data['user_email'] = sanitize_email($_GET['email'] ?? '');
    
    return $data;
});