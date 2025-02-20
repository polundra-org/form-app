<?php

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];

$fp = fopen('../data/names.csv', 'a+');

// $headers = fgetcsv($fp, 100, ',');

// $items = [];

// while (!feof($fp)) {
//     $str = fgetcsv($fp, 1000, ',');
    
//     echo '<pre>';
//     print_r($str);
//     echo '</pre>';
    
   // echo gettype($str);

    // $item = array_combine($headers, $str);
    // $items[] = $item;
// }

//  fseek($fp, 0, SEEK_END);

fputcsv($fp, $_POST, ',');

fclose($fp);

header("Location: result.php?first_name=$first_name&last_name=$last_name&email=$email");

exit;