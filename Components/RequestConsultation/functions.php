<?php
namespace Flynt\Components\RequestConsultation;

add_filter('Flynt/addComponentData?name=RequestConsultation', function ($data) {
    $postId = get_the_ID();
    $data['enable'] = get_field('enable_request_consultation', $postId) ?: false;
    $data['cf7_form_id'] = get_field('cf7_form_id', $postId);
    $data['custom_fields'] = get_field('consultation_custom_fields', $postId) ?: [];
    
    return $data;
});