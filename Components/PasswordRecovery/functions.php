<?php

namespace Flynt\Components\PasswordRecovery;

use Flynt\Utils\Options;
use WP_User;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=PasswordRecovery', function ($data) {
    global $wp;
    $data['request'] = [
        'get' => $_GET,
        'post' => $_POST
    ];
    return $data;
});

// Обработчик формы восстановления пароля
add_action('init', function() {
    if (!isset($_POST['action']) || $_POST['action'] !== 'recover_password') {
        return;
    }

    // Проверка nonce
    if (!isset($_POST['password_recovery_nonce_field']) ||
        !wp_verify_nonce($_POST['password_recovery_nonce_field'], 'verify_true_recovery_password')) {
        return;
    }

    // Получаем email
    $email = isset($_POST['username_email']) ? sanitize_email($_POST['username_email']) : '';

    if (empty($email)) {
        return;
    }

    // Ищем пользователя
    $user = get_user_by('email', $email);
    if (!$user) {
        $user = get_user_by('login', $email);
    }

    if (!$user) {
        return;
    }

    // Генерируем ключ сброса
    $key = get_password_reset_key($user);
    if (is_wp_error($key)) {
        error_log('Reset key error: ' . $key->get_error_message());
        return;
    }

    // Формируем ссылку сброса
    $reset_link = home_url('/password/') . '?key=' . $key . '&login=' . rawurlencode($user->user_login);

    // Отправляем письмо
    $subject = 'Сброс пароля';
    $message = '
    <html>
    <head>
        <title>Сброс пароля</title>
    </head>
    <body>
        <p>Для сброса пароля перейдите по ссылке:</p>
        <p><a href="' . esc_url($reset_link) . '">' . esc_url($reset_link) . '</a></p>
        <p>Если вы не запрашивали сброс пароля, проигнорируйте это письмо.</p>
    </body>
    </html>
    ';

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Snapget <no-reply@test.snapget.ru>'
    );

    $sent = wp_mail($email, $subject, $message, $headers);

    if ($sent) {
        // Редирект на страницу подтверждения
        $redirect_url = add_query_arg([
            'password_reset' => '1',
            'email' => urlencode($email)
        ], home_url('/check-email/'));

        wp_redirect($redirect_url);
        exit;
    }
});


// Обработчик формы сброса пароля
add_action('init', function() {
    if (!isset($_POST['new_password']) || !isset($_POST['confirm_password'])) {
        return;
    }

    $key = sanitize_text_field($_POST['key']);
    $login = sanitize_text_field($_POST['login']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        wp_die('Пароли не совпадают');
    }

    // Проверяем ключ
    $user = check_password_reset_key($key, $login);

    if (is_wp_error($user)) {
        wp_die('Неверный ключ сброса или срок действия истек');
    }

    // Устанавливаем новый пароль
    reset_password($user, $new_password);

    // Редирект после успешного сброса
    wp_redirect(home_url('/log-in'));
    exit;
});

// Шорткод для формы сброса пароля
add_shortcode('password_reset_form', function() {
    if (isset($_GET['key']) && isset($_GET['login'])) {
        ob_start();
        ?>
        <form method="post" class="password-reset-form wppb-user-forms">
            <input type="hidden" name="key" value="<?= esc_attr($_GET['key']) ?>">
            <input type="hidden" name="login" value="<?= esc_attr($_GET['login']) ?>">

            <div class="wppb-form-field">
                <label for="new_password">Пароль</label>
                <input placeholder="Пароль*" type="password" name="new_password" id="new_password" required>
            </div>

            <div class="wppb-form-field">
                <label for="confirm_password">Повторите пароль</label>
                <input placeholder="Повторите пароль*" type="password" name="confirm_password" id="confirm_password" required>
            </div>

            <button type="submit" class="submit button">Сохранить новый пароль</button>
        </form>
        <?php
        return ob_get_clean();
    }
    return '';
});

Options::addTranslatable('PasswordRecovery', [
    [
        'label' => __('Title', 'flynt'),
        'name' => 'title',
        'type' => 'text',
        'default_value' => __('Password recovery', 'flynt')
    ],
    [
        'label' => __('Text', 'flynt'),
        'name' => 'text',
        'type' => 'text',
        'default_value' => __("Придумайте новый пароль.", 'flynt')
    ],
]);
