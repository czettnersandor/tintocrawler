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

    public function getConfig($name)
    {
        if (isset($this->config[$name])) {
            return $this->config[$name];
        }
    }

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
            throw new Exception("Invalid login", 1);
        }
    }

    public function getData($name)
    {
        preg_match("/$name\\.addRows\((.*)\);;/im", $this->content, $matches);

        $dateRegex = "/(new Date\\((\\d{4}),(\\d{1,2}),(\\d{1,2}),(\\d{1,2}),(\\d{1,2}),(\\d{1,2})\\))/im";

        $jsData = preg_replace($dateRegex, '"$2-$3-$4 $5:$6:$7"', $matches[1]);

        return json_decode($jsData);
    }
}
