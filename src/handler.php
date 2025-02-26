<?php

define('CSV_PATH', '../data/requests.csv');

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$request = [$first_name, $last_name, $email];

function csvRead()
{   
    $fp = fopen(CSV_PATH, 'r+');
    $headers = fgetcsv($fp, 100, ',');
    $items = [];

    while (!feof($fp)) {
        $items[] = fgetcsv($fp, 100, ',');
    }
    
    fclose($fp);
    
    return $items;
}

function csvWrite(array $request)
{   
    $fp = fopen(CSV_PATH, 'a+');
    fputcsv($fp, $request, ',');
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
    csvWrite($request);
    $message = false;
}

header("Location: result.php?first_name=$first_name&last_name=$last_name&email=$email&message=$message");

exit;