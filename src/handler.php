<?php

define('DEFAULT_FNAME', 'Andrey');
define('DEFAULT_LNAME', 'Gubin');
define('DEFAULT_EMAIL', 'girls_like_stars@gmail.com');

class Handler
{
    public function __construct(public string $csvPath) {}

    public function addData(array $request) : bool
    {
        if ($this->emailExist($request[2])) {
            $message = false;
        } else {
            $this->wLine($request);
            $message = true;
        }

        return $message;
    }

    private function wLine(array $request) : void
    {   
        $fp = fopen($this->csvPath, 'a+');
        fputcsv($fp, $request, ',');
        fclose($fp);
    }

    private function emailExist(string $email) : bool
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

    private function rLine(string $email) : array | null
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
$message = $handler->addData($request);

header("Location: result.php?first_name=$first_name&last_name=$last_name&email=$email&message=$message");
