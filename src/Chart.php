<?php

namespace  Tinto;

class Chart
{

    protected $db;

    /**
     * Constructor
     *
     * @param \Tinto\Database $db Database object
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function generate($table)
    {
        $db = $this->db;

        $filename = 'public/data/' . $table . '.json';
        $genClass = 'Tinto\\Chart\\' . ucfirst($table) . 'Generator';
        $generator = new $genClass($db);
        $json = $generator->generate();

        file_put_contents($filename, json_encode($json));
    }
}
