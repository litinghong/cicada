<?php

use PHPUnit\Framework\TestCase;
use qxb\cicada\Client;
use qxb\cicada\Config;

class ClientTest extends TestCase
{
    public function testClient()
    {
        Config::setServer('http://127.0.0.1:6788/server.php');
        $client = new Client('aaa');
        try {
            $res = $client->entryPoint('a');
            echo json_encode($res);
        } catch (Exception $exception) {
            echo sprintf("exception = %s", $exception->getMessage());
        }
    }

    public function testGetInterface(){
        Config::setServer('http://127.0.0.1:6788/server.php');
        $client = new Client();
        $res = $client->getInterface();
        echo json_encode($res);
    }
}