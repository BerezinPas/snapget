<?php
/**
 * Template Name: Check Email
 */
use Timber\Timber;

$context = Timber::context();
$post = Timber::get_post();

// Получаем параметры
$email = isset($_GET['email']) ? sanitize_email($_GET['email']) : '';
$is_new_user = isset($_GET['new_user']);
$is_password_reset = isset($_GET['password_reset']);

$context['user_email'] = $email;
$context['is_password_reset'] = $is_password_reset;

// Основная логика обработки
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resend_email'])) {
    // Получаем email из формы
    if (empty($email) && isset($_POST['email'])) {
        $email = sanitize_email($_POST['email']);
        $context['user_email'] = $email;
    }

    if (empty($email)) {
        $context['message'] = 'Email не указан';
    } else {
        if ($is_password_reset) {
            // Восстановление пароля
            $user = get_user_by('email', $email);
            if ($user) {
                $key = get_password_reset_key($user);
                if (!is_wp_error($key)) {
                    $reset_link = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login');
                    
                    // Отправляем письмо
                    $subject = 'Сброс пароля';
                    $message = "Для сброса пароля перейдите по ссылке: $reset_link";
                    
                    if (wp_mail($email, $subject, $message)) {
                        $context['message'] = 'Письмо с инструкциями отправлено на ' . $email;
                    } else {
                        $context['message'] = 'Ошибка отправки письма';
                    }
                } else {
                    $context['message'] = 'Ошибка генерации ключа';
                }
            } else {
                $context['message'] = 'Пользователь не найден';
            }
        } else {
            // Активация нового пользователя
            global $wpdb;
            $signup = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}signups WHERE user_email = %s",
                $email
            ));

            if ($signup) {
                // Отправляем письмо активации
                if (function_exists('wppb_signup_user_notification')) {
                    wppb_signup_user_notification($signup->user_login, $email, $signup->activation_key, '');
                    $context['message'] = 'Письмо с подтверждением отправлено на ' . $email;
                } else {
                    $context['message'] = 'Ошибка: функция отправки не найдена';
                }
            } else {
                $context['message'] = 'Пользователь не найден или уже активирован';
            }
        }
    }
}

Timber::render('templates/page-check-email.twig', $context);