<?php

// $fp = fopen('../data/names.csv', 'r');

// $str = fgetcsv($fp);

// // if ($fp) {
// //     while (!feof($fp)) {
// //         $str = fgetcsv($fp);
// //     }
// // }
// // fseek($fp, 0, SEEK_END);
// // fputcsv($fp, $_POST, ',');

// fclose($fp);

// echo '<pre>';
// print_r($str);
// echo '</pre>';

echo '<pre>';
print_r($_GET);
echo '</pre>';

$fullName = $_GET['first_name'] . ' ' . $_GET['last_name'];

echo "$fullName, Ваши данные сохранены. Запрос на подтверждение отправлен на почту: $_GET[email]";