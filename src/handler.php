<?php

define('CSV_PATH', '../data/names.csv');

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];

function csvRead()
{   
    $fp = fopen(CSV_PATH, 'r+');
    $headers = fgetcsv($fp, 100, ',');

    while (!feof($fp)) {
        $line = fgetcsv($fp, 100, ',');
        var_dump($line);

        $item = array_combine($headers, $line); // на последней итерации, функиця fgetscvs возвращает false и array_combine выдает ошибку, поскольку ждет на вход два массива.
        echo '<pre>';
        print_r($item);
        echo '</pre>';
    }

    fclose($fp);
}

function csvWrite()
{
    $fp = fopen(CSV_PATH, 'a+');
    fputcsv($fp, $_POST, ',');
    fclose($fp);
}

function csvEmailExixst()
{

}

csvWrite();
//csvRead();

//fseek($fp, 0, SEEK_END);

header("Location: result.php?first_name=$first_name&last_name=$last_name&email=$email");

exit;