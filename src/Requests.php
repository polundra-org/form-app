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
        $new = false;

        if(filesize($this->csvPath) === 0) {
            $new = true;
        } else {
            while (!feof($fp)) {
                $line = fgetcsv($fp, null, self::CSV_FIELD_SEPARATOR, self::CSV_FIELD_ENCLOSURE);

                var_dump($line);
                               
                if($line[2] === $email){
                    $line[3] += 1;
                    $line[4] = $lastSend->format(DateTimeInterface::ISO8601);
                    fputcsv($fpTemp, $line, self::CSV_FIELD_SEPARATOR, self::CSV_FIELD_ENCLOSURE);
                    $new = false;
                } else {
                    if($line) {
                        fputcsv($fpTemp, $line, self::CSV_FIELD_SEPARATOR, self::CSV_FIELD_ENCLOSURE);
                        $new = true;
                    }
                }
            }
        }

        if ($new) {
            $newLine = [$firstName, $lastName, $email, 1, $lastSend->format(DateTimeInterface::ISO8601)];
            fputcsv($fpTemp, $newLine, self::CSV_FIELD_SEPARATOR, self::CSV_FIELD_ENCLOSURE);
        }

        // var_dump(ftell($fp));       // 1
        // var_dump(ftell($fpTemp));  // 68

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
}
