<?php
// Указываем адрес электронной почты, на который будут отправляться данные
$to = 'Postscriptumfr@yandex.ru, miha.frolow2017@yandex.ru, cimbasonia@yandex.ru';

// Проверяем, что данные были отправлены методом POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем и фильтруем данные из формы
    $name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);

    // Проверка на заполненность полей
    if (empty($name) || empty($phone) || !$email) {
        echo '<script>alert("Пожалуйста, заполните все поля корректно.");</script>';
        exit;
    }

    // Формируем заголовки письма
    $subject = 'Новая заявка с сайта';
    $headers = "From: no-reply@yourdomain.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

    // Формируем тело письма
    $message = "Имя и фамилия: $name\n";
    $message .= "Номер телефона: $phone\n";
    $message .= "Электронная почта: $email\n";

    // Отправка письма и проверка результата
    if (mail($to, $subject, $message, $headers)) {
        // Если отправка прошла успешно, выводим сообщение и перенаправляем на главную страницу
        echo '<script>
                alert("Сообщение успешно отправлено.");
                window.location.href = "/"; // Перенаправление на главную страницу
                </script>';
    } else {
        // Если возникла ошибка при отправке
        echo '<script>alert("Ошибка при отправке сообщения. Попробуйте позже.");</script>';
        exit;
    }
} else {
    // Если данные не были отправлены методом POST
    echo '<script>alert("Неверный метод отправки данных.");</script>';
    exit;
}
