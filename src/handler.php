<?php

$fullName = $_POST['first_name'] . ' ' . $_POST['last_name'];

$fp = fopen('../data/names.csv', 'a+');

fseek($fp, 0, SEEK_END);
fputcsv($fp, $_POST, ',');

fclose($fp);

echo "$fullName, Ваши данные сохранены";