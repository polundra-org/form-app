<?php

require_once __DIR__ . '/user.php';

$email = $_GET['email'];
$message = $_GET['message'];

$csvPath = getenv('CSV_PATH');
$data = new User($csvPath);
$user = $data->readUser($email);

$fullName = $user[0] . ' ' . $user[1];

if ($_GET['message']) {
    echo "$fullName, Ваши данные сохранены. Запрос на подтверждение отправлен на почту: $email";
} else {
    echo "$fullName, Вы уже зарегестрированы. Ваша почта: $email";
}
