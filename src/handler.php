<?php

define('CSV_PATH', '../data/requests.csv');
define('DEFAULT_FNAME', 'Andrey');
define('DEFAULT_LNAME', 'Gubin');
define('DEFAULT_EMAIL', 'girls_like_stars@gmail.com');

class Handler
{
    const DEFAULT_FNAME = 'Andrey';
    const DEFAULT_LNAME = 'Gubin';
    const DEFAULT_EMAIL = 'girls_like_stars@gmail.com';

    public function __construct(public string $csvPath) {}

    public function wLine(array $request) : void
    {   
        $fp = fopen($this->csvPath, 'a+');
        fputcsv($fp, $request, ',');
        fclose($fp);
    }

    public function emailExist(string $email) : bool
    {
        $fp = fopen($this->csvPath, 'r+');
        $headers = fgetcsv($fp, 100, ',');
        
        while (!feof($fp)) {
            $item = fgetcsv($fp, 100, ',');
            
            if ($item[2] === $email) {
                return true;
            }
        }
        fclose($fp);
               
        return false;
    }

    public function rLine(string $email) : array | null
    {
        $fp = fopen($this->csvPath, 'r+');
        $headers = fgetcsv($fp, 100, ',');
        
        while (!feof($fp)) {
            $item = fgetcsv($fp, 100, ',');
            
            if ($item[2] === $email) {
                return $item;
            }
        }
        fclose($fp);

        return null;
    }
}

if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email'])) {
    $first_name = DEFAULT_FNAME;
    $last_name = DEFAULT_LNAME;
    $email = DEFAULT_EMAIL;
} else {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
} 

$request = [$first_name, $last_name, $email];

$handler = new Handler('../data/requests.csv');
$handler->wLine($request);
$out = $handler->rLine('gesha@rambler.ru');
var_dump($out);


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
