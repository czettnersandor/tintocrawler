<?php

namespace  Tinto\Chart;

use Tinto\Chart;

abstract class AbstractGenerator extends Chart
{
    protected $table;

    public function generate()
    {
        $db = $this->db;
        $results = $db->getData($this->table);

        $labels = [];
        $average = [];

        while ($data = $results->fetchArray()) {
            $labels[] = date('G:i', $data['timestamp']);
            $average[] = $data['avg'];
        }

        $json = [
            'labels' => $labels,
            'datasets' => [
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
            ],
        ];

        return $json;
    }
}
