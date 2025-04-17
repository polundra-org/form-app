<?php

class Requests
{
    const CSV_FIELD_SEPARATOR = ',';
    const CSV_FIELD_ENCLOSURE = '"';
    const TEMP_DIR = __DIR__ . '/../data';
    const TEMP_FILE_PREFIX = self::class;

    public function __construct(private string $csvPath) {}

    public function createOrUpdate(string $firstName, string $lastName, string $email, \DateTime $lastSend) : bool
    {   
        $tempFileName = tempnam(self::TEMP_DIR, self::TEMP_FILE_PREFIX);
        $fp = fopen($this->csvPath, 'r+');
        $fpTemp = fopen($tempFileName, 'a+');
        $new = true;

        if(filesize($this->csvPath) !== 0) {
            while (!feof($fp)) {
                $line = fgetcsv($fp, null, self::CSV_FIELD_SEPARATOR, self::CSV_FIELD_ENCLOSURE);
                                
                if($line[2] === $email){
                    $line[3] += 1;
                    $line[4] = $lastSend->format(DateTimeInterface::ISO8601);
                    fputcsv($fpTemp, $line, self::CSV_FIELD_SEPARATOR, self::CSV_FIELD_ENCLOSURE);
                    $new = false;
                } else {
                    if($line) {
                        fputcsv($fpTemp, $line, self::CSV_FIELD_SEPARATOR, self::CSV_FIELD_ENCLOSURE);
                    }
                }
            }
        }   

        if ($new) {
            $newLine = [$firstName, $lastName, $email, 1, $lastSend->format(DateTimeInterface::ISO8601)];
            fputcsv($fpTemp, $newLine, self::CSV_FIELD_SEPARATOR, self::CSV_FIELD_ENCLOSURE);
        }

        fclose($fp);
        fclose($fpTemp);
        rename($tempFileName, $this->csvPath);

        return $new;
    }

    public function read(string $email) : array | null
    {
        $fp = fopen($this->csvPath, 'r+');
        
        while (!feof($fp)) {
            $line = fgetcsv($fp, null, self::CSV_FIELD_SEPARATOR, self::CSV_FIELD_ENCLOSURE);
            
            if ($line[2] === $email) {
                $line[4] = DateTime::createFromFormat(DateTimeInterface::ISO8601, $line[4]);
                return $line;
            }
        }
        fclose($fp);

        return null;
    }

    public function filterImportData() : array | null
    {
        require_once $this->csvPath;

        $emails = [];
        $noErrorsData = [];
        $result = [];
        $filterLog = [
            "success" => 0,
            "duplicate" => 0,
            "errors" => 0,
            "total" => 0
        ];

        if (empty(DATA)) {
            return null;
        }

        foreach (DATA as $item) {
            $filterLog['total'] += 1; 
            
            if (empty($item['first_name']) || empty($item['last_name']) || empty($item['email'])) {
                $filterLog['errors'] += 1;
            } else {
                $noErrorsData[] = $item;
                $emails[] = $item['email'];
            }
        }

        $withDublicates = count($emails);
        $emails = array_unique($emails, SORT_STRING);
        $withOutDublicates = count($emails);
        
        $filterLog['duplicate'] = $withDublicates - $withOutDublicates;
        $filterLog['success'] = $withOutDublicates;
        
        foreach ($emails as $key => $email) {
            if (array_key_exists($key, $noErrorsData)) {
                $result[] = $noErrorsData[$key];
            }
        }   

        echo '<pre>';
        print_r($filterLog);
        echo '</pre>';

        echo '<pre>';
        print_r($result);
        echo '</pre>';

        return [$filterLog, $result];
    }
}
