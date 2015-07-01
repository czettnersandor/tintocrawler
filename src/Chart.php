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

        $json = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Minimum',
                    'fillColor' => 'rgba(220,220,220,0.2)',
                    'strokeColor' => 'rgba(220,220,220,1)',
                    'pointColor' => 'rgba(220,220,220,1)',
                    'pointStrokeColor' => '#fff',
                    'pointHighlightFill' => '#fff',
                    'pointHighlightStroke' => 'rgba(220,220,220,1)',
                    'data' => [],
                ],
                [
                    'label' => 'Maximum',
                    'fillColor' => 'rgba(255,220,220,0.2)',
                    'strokeColor' => 'rgba(255,220,220,1)',
                    'pointColor' => 'rgba(255,220,220,1)',
                    'pointStrokeColor' => '#fff',
                    'pointHighlightFill' => '#fff',
                    'pointHighlightStroke' => 'rgba(255,220,220,1)',
                    'data' => [],
                ],
                [
                    'label' => 'Average',
                    'fillColor' => 'rgba(220,255,220,0.2)',
                    'strokeColor' => 'rgba(220,255,220,1)',
                    'pointColor' => 'rgba(220,255,220,1)',
                    'pointStrokeColor' => '#fff',
                    'pointHighlightFill' => '#fff',
                    'pointHighlightStroke' => 'rgba(220,255,220,1)',
                    'data' => [],
                ],

            ],
        ];

        switch($table) {
            case 'windstrength':
                $filename = 'public/data/windstrength.json';
                break;
            default:
                throw new Exception('Data table is not paired with json file');
        }


        file_put_contents($filename, json_encode($json));
    }
}
