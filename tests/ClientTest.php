<?php

use PHPUnit\Framework\TestCase;
use qxb\cicada\Client;
use qxb\cicada\Config;

class ClientTest extends TestCase
{
    public function testClient()
    {
        Config::setServer('http://apiserver/Open/RPC/test');
        $client = new Client('aaa');
        try {
            $res = $client->entryPoint('a');
            echo json_encode($res);
        } catch (Exception $exception) {
            echo sprintf("exception = %s", $exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function testGetInterface(){
        Config::setServer('http://apiserver/Open/RPC/test');
        $savePath = '../runtime';
        @mkdir($savePath);
        Config::setInterfacePath(realpath($savePath));

        $client = new Client();
        $client->getInterface();
        $this->assertFileExists($savePath);
    }
}