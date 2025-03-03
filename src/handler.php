<?php

// define('CSV_PATH', '../data/requests.csv');
// define('DEFAULT_FNAME', 'Andrey');
// define('DEFAULT_LNAME', 'Gubin');
// define('DEFAULT_EMAIL', 'girls_like_stars@gmail.com');

class Handler
{
    const CSV_PATH = '../data/requests.csv';
    const DEFAULT_FNAME = 'Andrey';
    const DEFAULT_LNAME = 'Gubin';
    const DEFAULT_EMAIL = 'girls_like_stars@gmail.com';

    public function __construct(public string $csvPath) {}

    public function addHeaders() : void
    {   
        $fp = fopen($this->csvPath, 'w');
        fputcsv($fp, ['first_name', 'last_name', 'email'], ',');
        fclose($fp);
    }

}

$handler = new Handler('../data/requests.csv');
$handler-> addHeaders();


// if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email'])) {
//     $first_name = DEFAULT_FNAME;
//     $last_name = DEFAULT_LNAME;
//     $email = DEFAULT_EMAIL;
// } else {
//     $first_name = $_POST['first_name'];
//     $last_name = $_POST['last_name'];
//     $email = $_POST['email'];
// } 

// $request = [$first_name, $last_name, $email];

// function csvRead()
// {   
//     $fp = fopen(CSV_PATH, 'r+');
//     $headers = fgetcsv($fp, 100, ',');
//     $items = [];

//     while (!feof($fp)) {
//         $items[] = fgetcsv($fp, 100, ',');
//     }
    
//     fclose($fp);
    
//     return $items;
// }

// function csvWrite(array $request)
// {   
//     $fp = fopen(CSV_PATH, 'a+');
//     fputcsv($fp, $request, ',');
//     fclose($fp);
// }

// function csvEmailExixst($email)
// {
//     $items = csvRead();

//     foreach ($items as $item) {
//         if ($item[2] === $email) {
//             return true;
//         }
//     }

//     return false;
// }

// if (csvEmailExixst($email)) {
//     $message = true;
// } else {
//     csvWrite($request);
//     $message = false;
// }

// header("Location: result.php?first_name=$first_name&last_name=$last_name&email=$email&message=$message");
