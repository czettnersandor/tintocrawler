<?php

namespace  Tinto;

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

        switch ($table) {
            case 'windstrength':
                $filename = 'public/data/windstrength.json';
                $generator = new Chart\WindstrengthGenerator($db);
                $json = $generator->generate();
                break;
            case 'winddirection':
                $filename = 'public/data/winddirection.json';
                $generator = new Chart\WinddirectionGenerator($db);
                $json = $generator->generate();
                break;
            case 'temperature':
                $filename = 'public/data/temperature.json';
                $generator = new Chart\TemperatureGenerator($db);
                $json = $generator->generate();
                break;
            case 'humidity':
                $filename = 'public/data/humidity.json';
                $generator = new Chart\HumidityGenerator($db);
                $json = $generator->generate();
                break;
            case 'brightness':
                $filename = 'public/data/brightness.json';
                $generator = new Chart\BrightnessGenerator($db);
                $json = $generator->generate();
                break;
            case 'pressure':
                $filename = 'public/data/pressure.json';
                $generator = new Chart\PressureGenerator($db);
                $json = $generator->generate();
                break;
            default:
                throw new \Exception('Data table is not paired with json file');
        }


        file_put_contents($filename, json_encode($json));
    }
}
