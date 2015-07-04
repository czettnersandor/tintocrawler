<?php

namespace  Tinto\Chart;

use Tinto\Chart;

class WindstrengthGenerator extends AbstractGenerator
{

    protected $table = 'windstrength';

    public function generate()
    {
        $db = $this->db;
        $results = $db->getData($this->table);

        $labels = [];
        $minimum = [];
        $maximum = [];
        $average = [];

        while ($data = $results->fetchArray()) {
            $labels[] = date('G:i', $data['timestamp']);
            $minimum[] = $data['min'];
            $maximum[] = $data['max'];
            $average[] = $data['avg'];
        }

        $json = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Maximum',
                    'fillColor' => 'rgba(255,50,50,0.2)',
                    'strokeColor' => 'rgba(255,50,50,1)',
                    'pointColor' => 'rgba(255,50,50,1)',
                    'pointStrokeColor' => '#fff',
                    'pointHighlightFill' => '#fff',
                    'pointHighlightStroke' => 'rgba(255,50,50,1)',
                    'data' => $maximum,
                ],
                [
                    'label' => 'Average',
                    'fillColor' => 'rgba(50,155,50,0.2)',
                    'strokeColor' => 'rgba(50,155,50,1)',
                    'pointColor' => 'rgba(50,155,50,1)',
                    'pointStrokeColor' => '#fff',
                    'pointHighlightFill' => '#fff',
                    'pointHighlightStroke' => 'rgba(50,255,50,1)',
                    'data' => $average,
                ],
                [
                    'label' => 'Minimum',
                    'fillColor' => 'rgba(255,255,255,0.2)',
                    'strokeColor' => 'rgba(50,50,50,1)',
                    'pointColor' => 'rgba(50,50,50,1)',
                    'pointStrokeColor' => '#fff',
                    'pointHighlightFill' => '#fff',
                    'pointHighlightStroke' => 'rgba(50,50,50,1)',
                    'data' => $minimum,
                ],

            ],
        ];

        return $json;
    }
}
