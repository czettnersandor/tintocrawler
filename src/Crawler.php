<?php

namespace  Tinto;

use Goutte\Client;

class Crawler
{

    protected $config;

    protected $content;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * get Configuration value defined in config.php
     *
     * @param  string $name Name
     *
     * @return string Value
     */
    public function getConfig($name)
    {
        if (isset($this->config[$name])) {
            return $this->config[$name];
        }
    }

    /**
     * Logs in to thw Windtalker and saves the whole page in $this->content
     *
     * @return void
     */
    public function auth()
    {
        $client = new Client();

        $crawler = $client->request('GET', $this->getConfig('url'));

        $form = $crawler->selectButton('Sign In')->form();
        $crawler = $client->submit(
            $form,
            array(
                'userNameOrEmail' => $this->getConfig('username'),
                'password' => $this->getConfig('password')
            )
        );

        $this->content = $crawler->text();

        if (strpos("Please enter your username and password", $this->content)) {
            throw new \Exception("Invalid login", 1);
        }
    }

    /**
     * Parse data from the Google Chart json using a regex.
     *
     * @param  string $name JSON variable name
     *
     * @return Array        Decoded JSON
     */
    public function getData($name)
    {
        preg_match("/$name\\.addRows\((.*)\);;/im", $this->content, $matches);

        $dateRegex = "/(new Date\\((\\d{4}),(\\d{1,2}),(\\d{1,2}),(\\d{1,2}),(\\d{1,2}),(\\d{1,2})\\))/im";

        $jsData = preg_replace($dateRegex, '"$2-$3-$4 $5:$6:$7"', $matches[1]);

        return json_decode($jsData);
    }
}
