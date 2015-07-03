<?php

namespace  Tinto;

use Goutte\Client;

class Chart
{

    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function generate($table)
    {
        $db = $this->db;
        $labels = [];
        $minimum = [];
        $maximum = [];
        $average = [];

        switch ($table) {
            case 'windstrength':
                $filename = 'public/data/windstrength.json';
                $generator = new Chart\WindstrengthGenerator($db);
                $json = $generator->generate();
                break;
            default:
                throw new Exception('Data table is not paired with json file');
        }


        file_put_contents($filename, json_encode($json));
    }
}
