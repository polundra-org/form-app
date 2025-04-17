<?php

require_once __DIR__ . '/Requests.php';

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

// $csvPath = getenv('CSV_PATH');
// $requests = new Requests($csvPath);
// $requests->createOrUpdate($first_name, $last_name, $email, new DateTime());

$importPath = getenv('IMPORT_PATH');
$requests = new Requests($importPath);
$requests->filterImportData();

//header("Location: request_info.php?email=$email");
