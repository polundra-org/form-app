<?php

class User
{
    public function __construct(private string $csvPath) {}

    public function addUser(string $first_name, string $last_name, string $email, int $resends_number, string $last_send) : bool
    {
        if ($this->isUserExist($email)) {
            $message = false;
        } else {
            $this->writeUser($first_name, $last_name, $email, $resends_number, $last_send);
            $message = true;
        }

        return $message;
    }

    private function writeUser(string $first_name, string $last_name, string $email, int $resends_number, string $last_send) : void
    {   
        $request = [$first_name, $last_name, $email, $resends_number, $last_send];
        $fp = fopen($this->csvPath, 'a+');
        fputcsv($fp, $request, ',');
        fclose($fp);
    }

    private function isUserExist(string $email) : bool
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

    public function readUser(string $email) : array | null
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
