<?php

define('CSV_PATH', '../data/names.csv');

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];

function csvRead()
{   
    $fp = fopen(CSV_PATH, 'r+');
    $headers = fgetcsv($fp, 100, ',');
    $items = [];

    while (!feof($fp)) {
        // $line = fgetcsv($fp, 100, ',');
        // $items[] = array_combine($headers, $line); 
        // на последней итерации, функиця fgetcvs возвращает false и array_combine выдает ошибку, 
        // поскольку ждет на вход два массива. очевидно все дело в последнее пустой строке в csv, по логике
        // fgetcsv на ней должна вернуть масcив [null]
        // если убрать пустую последнюю строку то все работает, но тогда записть в csv, дописывает линию в конец уже существующей строки
        // https://github.com/polundra-org/lab-01/blob/main/src/traits/CsvReader.php вот тут аналогичный код. но он работате без этой ошибки, почему?

        $items[] = fgetcsv($fp, 100, ',');
    }
    
    fclose($fp);
    
    return $items;
}

function csvWrite()
{
    $fp = fopen(CSV_PATH, 'a+');
    fputcsv($fp, $_POST, ',', '"', '', "\n");
    fclose($fp);
}

function csvEmailExixst($email)
{
    $items = csvRead();

    foreach ($items as $item) {
        if ($item[2] === $email) {
            return true;
        }
    }

    return false;
}

if (csvEmailExixst($email)) {
    $message = true;
} else {
    csvWrite();
    $message = false;
}

header("Location: result.php?first_name=$first_name&last_name=$last_name&email=$email&message=$message");

exit;