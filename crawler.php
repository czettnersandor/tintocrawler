<?php

require_once('vendor/autoload.php');

use Tinto\Crawler;
use Tinto\Database;
use Tinto\Chart;

$config = require('config.php');

$db = new Database\Sqlite;
$chart = new Chart($db);

$crawler = new Crawler($config);
$crawler->auth();

$windstrength = $crawler->getData('d4'); // d4 is the temperature data
$winddirection = $crawler->getData('d11');
$temperature = $crawler->getData('d5');
$humidity = $crawler->getData('d6');
$brightness = $crawler->getData('d8');
$pressure = $crawler->getData('d9');

$db->insert($windstrength, 'windstrength');
$db->insert($winddirection, 'winddirection');
$db->insert($temperature, 'temperature');
$db->insert($humidity, 'humidity');
$db->insert($brightness, 'brightness');
$db->insert($pressure, 'pressure');

$chart->generate('windstrength');
$chart->generate('winddirection');
$chart->generate('temperature');
$chart->generate('humidity');
$chart->generate('brightness');
$chart->generate('pressure');
