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
}
