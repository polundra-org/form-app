<?php

require_once __DIR__ . '/user.php';

define('DEFAULT_FNAME', 'Andrey');
define('DEFAULT_LNAME', 'Gubin');
define('DEFAULT_EMAIL', 'girls_like_stars@gmail.com');

if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email'])) {
    $first_name = DEFAULT_FNAME;
    $last_name = DEFAULT_LNAME;
    $email = DEFAULT_EMAIL;
} else {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
} 

$user = new User('../data/requests.csv');
$message = $user->addUser($first_name, $last_name, $email);

header("Location: result.php?email=$email&message=$message");
