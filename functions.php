<?php

namespace Flynt;

use Flynt\Utils\FileLoader;

require_once __DIR__ . '/vendor/autoload.php';

if (!defined('WP_ENV')) {
    define('WP_ENV', function_exists('wp_get_environment_type') ? wp_get_environment_type() : 'production');
} elseif (!defined('WP_ENVIRONMENT_TYPE')) {
    define('WP_ENVIRONMENT_TYPE', WP_ENV);
}

// Check if the required plugins are installed and activated.
// If they aren't, this function redirects the template rendering to use
// plugin-inactive.php instead and shows a warning in the admin backend.
if (Init::checkRequiredPlugins()) {
    FileLoader::loadPhpFiles('inc');
    add_action('after_setup_theme', ['Flynt\Init', 'initTheme']);
    add_action('after_setup_theme', ['Flynt\Init', 'loadComponents'], 101);
}

// Remove the admin-bar inline-CSS as it isn't compatible with the sticky footer CSS.
// This prevents unintended scrolling on pages with few content, when logged in.
add_theme_support('admin-bar', ['callback' => '__return_false']);

add_action('after_setup_theme', function () {
    // Make theme available for translation.
    // Translations can be filed in the /languages/ directory.
    load_theme_textdomain('flynt', get_template_directory() . '/languages');


    // delete
    add_theme_support('html5', ['comment-form', 'comment-list']);
    add_theme_support('comments');
});

add_filter('gettext', function ($translated_text){
    if($translated_text == 'Username'){
        return 'Логин';
    } elseif($translated_text == 'Password'){
        return 'Пароль';
    } elseif($translated_text == 'Log In'){
        return 'Войти';
    } elseif($translated_text == 'Lost your password?'){
        return 'Забыли пароль?';
    } elseif($translated_text == 'Register'){
        return 'Зарегистрироваться';
    } elseif($translated_text == 'Password recovery'){
        return 'Восстановление пароля';
    } elseif($translated_text == 'Enter the information you provided during registration. If you don\'t remember them, write to technical support.'){
        return 'Введите данные, указанные при регистрации. Если вы их не помните, напишите в техподдержку.';
    } elseif($translated_text == 'The username entered wasn\'t found in the database!'){
        return 'Имя пользователя не найдено на сайте!';
    } elseif($translated_text == 'Please check that you entered the correct username.'){
        return 'Пожалуйста, проверьте, что вы ввели правильное имя пользователя.';
    } elseif($translated_text == 'Please enter your username or email address.'){
        return 'Введите ваше имя пользователя или адрес электронной почты.';
    } elseif($translated_text == 'Username or Email'){
        return 'Логин или Емаил';
    } elseif($translated_text == 'You will receive a link to create a new password via email.'){
        return 'Ссылку для создания нового пароля вы получите по электронной почте.';
    } elseif($translated_text == 'Get New Password'){
        return 'Получить новый пароль';
    } elseif($translated_text == 'The password must have a minimum strength of %s'){
        return 'Пароль должен иметь высокий уровень надежности';
    } elseif($translated_text == 'Strength indicator'){
        return 'Уровень надежности';
    } elseif($translated_text == 'This field is required'){
        return 'Это поле обязательно к заполнению';
    } elseif($translated_text == 'Send these credentials via email'){
        return 'Отправить эти учетные данные по электронной почте';
    } elseif($translated_text == 'There was an error in the submitted form'){
        return 'В заполненой форме обнаружена ошибка.';
    } elseif($translated_text == 'I agree with the rules and regulations'){
        return 'Я согласен(а) с правилами и правилами.';
    }
    //print $translated_text.' | ';
    return $translated_text;
});
//редирект в личный кабинет
add_filter( 'login_redirect', function ($redirect_to, $request, $user){
    if ( isset( $user->roles ) && is_array( $user->roles ) && in_array( 'administrator', $user->roles ) ) {
        return home_url( '/wp-admin/' );
    } else {
        return home_url( '/user-profile/' );
    }
}, 10, 3 );

add_action( 'template_redirect', function (){
    //редирект со страницы входа, если залогинен
    if ( is_page('log-in') ) {
        $user = wp_get_current_user();
        if(!empty($user->data->user_login)){
            $redirect_url = home_url( '/user-profile/' );
            wp_redirect( $redirect_url );
            exit;
        }
    }
    //Разлогиниться
    if ( is_page('log-out') ) {
        $user = wp_get_current_user();
        if(!empty($user->data)){
            wp_logout();
        }
        $redirect_url = home_url( '/' );
        wp_redirect( $redirect_url );
        exit;
    }

    // // Завершение регистрации
    //  if (!is_user_logged_in() || current_user_can('administrator')) {
    //     return;
    // }

    // // Исключаем страницу complete и AJAX-запросы
    // if (is_page('complete') || wp_doing_ajax()) {
    //     return;
    // }

    // // Получаем ID пользователя
    // $user_id = get_current_user_id();

    // // Проверяем, заполнены ли обязательные поля
    // $telegram = get_field('telegram', 'user_' . $user_id);
    // $activity = get_field('activity', 'user_' . $user_id);

    // // Если хотя бы одно поле не заполнено - редирект
    // if (empty($telegram) || empty($activity)) {
    //     wp_redirect(home_url('/complete/'));
    //     exit;
    // }


});



// Редирект после регистации
add_filter('wppb_register_redirect', function($redirect_url) {
    if (isset($_POST['email'])) {
        $email = urlencode(sanitize_email($_POST['email']));
        return home_url('/check-email/').'?email='.$email.'&new_user=1';
    }
    return $redirect_url;
});

// Фикс для функции moveForm
add_filter('comment_reply_link', function($link, $args, $comment) {
    return str_replace(
        "onclick='return addComment.moveForm", 
        "onclick='return addComment.moveForm", 
        $link
    );
}, 10, 3);



// add_filter( 'wppb_register_success_message', function ( $content, $account_name ){
//     $loader = 'РЩ <svg width="78" height="78" viewBox="0 0 78 78" fill="none" xmlns="http://www.w3.org/2000/svg"> <g style="mix-blend-mode:screen"> <rect width="78" height="78" fill="#802CD9"/> </g></svg>';
//     // $loader = 'РУДДЩ';
//    return $loader;
// }, 10, 2 );



