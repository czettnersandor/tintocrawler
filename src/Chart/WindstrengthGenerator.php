<?php

namespace  Tinto\Chart;

use Goutte\Client;

use Tinto\Chart;

class WindstrengthGenerator extends Chart
{
    public function generate()
    {
        $db = $this->db;
        $results = $db->getData('windstrength');

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
                    'label' => 'Minimum',
                    'fillColor' => 'rgba(220,220,220,0.2)',
                    'strokeColor' => 'rgba(220,220,220,1)',
                    'pointColor' => 'rgba(220,220,220,1)',
                    'pointStrokeColor' => '#fff',
                    'pointHighlightFill' => '#fff',
                    'pointHighlightStroke' => 'rgba(220,220,220,1)',
                    'data' => $minimum,
                ],
                [
                    'label' => 'Maximum',
                    'fillColor' => 'rgba(255,220,220,0.2)',
                    'strokeColor' => 'rgba(255,220,220,1)',
                    'pointColor' => 'rgba(255,220,220,1)',
                    'pointStrokeColor' => '#fff',
                    'pointHighlightFill' => '#fff',
                    'pointHighlightStroke' => 'rgba(255,220,220,1)',
                    'data' => $maximum,
                ],
                [
                    'label' => 'Average',
                    'fillColor' => 'rgba(220,255,220,0.2)',
                    'strokeColor' => 'rgba(220,255,220,1)',
                    'pointColor' => 'rgba(220,255,220,1)',
                    'pointStrokeColor' => '#fff',
                    'pointHighlightFill' => '#fff',
                    'pointHighlightStroke' => 'rgba(220,255,220,1)',
                    'data' => $average,
                ],

            ],
        ];

        return $json;
    }
}
