<?php

namespace qxb\cicada;

class Client
{
    private $client;
    private $instance;

    public function __construct($instance = null)
    {
        $this->instance = $instance;
        $server = Config::getServer();
        $this->client = new \Hprose\Http\Client($server, false);
        return $this->client;
    }

    public function __call($name, $arguments)
    {
        $params = [
            $this->instance,
            $name,
            $arguments,
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