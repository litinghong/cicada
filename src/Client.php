<?php

namespace qxb\cicada;

class Client
{
    private $client;
    private $instance;
    private $token = '';
    public function __construct($instance = null)
    {
        $this->instance = $instance;
        $server = Config::getServer();
        $this->token = Config::getToken();
        $this->client = new \Hprose\Http\Client($server, false);
        return $this->client;
    }

    public function __call($name, $arguments)
    {
        $params = [
            $this->instance,
            $name,
            $arguments,
            $this->token,
        ];
        return $this->client->invoke('entryPoint', $params);
    }

    public function getInterface()
    {
        $token = Config::getToken();
        $params = [$token];
        return $this->client->invoke('getInterface', $params);
    }
}