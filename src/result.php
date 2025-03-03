<?php

$fullName = $_GET['first_name'] . ' ' . $_GET['last_name'];

if ($_GET['message']) {
    echo "$fullName, Ваши данные сохранены. Запрос на подтверждение отправлен на почту: $_GET[email]";
} else {
    echo "$fullName, Вы уже зарегестрированы. Ваша почта: $_GET[email]";
}
