<?php

class Import
{
    public function __construct(private string $importPath) {}

    public function filterImportData() : array | null
    {
        require_once $this->importPath;

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

    // public function import() : bool
    // {
    //     filterImportData()
    // }
}