<?php

require_once __DIR__ . '/user.php';

define('DEFAULT_FNAME', 'Andrey');
define('DEFAULT_LNAME', 'Gubin');
define('DEFAULT_EMAIL', 'girls_like_stars@gmail.com');

$date = new DateTime('now');
$lastResponseDate = $date->format('Y-m-d H:i:s');

if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email'])) {
    $first_name = DEFAULT_FNAME;
    $last_name = DEFAULT_LNAME;
    $email = DEFAULT_EMAIL;
    $resends_number = 1;
    $last_send = $lastResponseDate;
} else {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $resends_number = 1;
    $last_send = $lastResponseDate;
} 

$csvPath = getenv('CSV_PATH');
$user = new User($csvPath);
$message = $user->addUser($first_name, $last_name, $email, $resends_number, $last_send);

header("Location: result.php?email=$email&message=$message");
