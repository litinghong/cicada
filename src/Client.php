<?php

namespace qxb\cicada;

use Exception;
use ReflectionClass;
use ReflectionException;

class Client
{
    private $client;
    private $token = '';
    private $clientNamespace = '';
    private $serverClsName = '';

    /**
     * Client constructor.
     * @param null $instance
     * @throws ReflectionException
     */
    public function __construct($instance = null)
    {
        $server = Config::getServer();
        $this->token = Config::getToken();
        $this->clientNamespace = Config::getInterfaceNamespace();

        if($instance) {
            $clsIf = new ReflectionClass($instance);
            $this->serverClsName = str_replace($this->clientNamespace, '', $clsIf->getName());
        }
        $this->client = new \Hprose\Http\Client($server, false);
        return $this->client;
    }

    public function __call($name, $arguments)
    {
        $params = [
            $this->serverClsName,
            $name,
            $arguments,
            $this->token,
        ];
        return $this->client->invoke('entryPoint', $params);
    }

    /**
     * @param null|string $nsRoot 新的命名空间根目录
     * @throws Exception
     */
    public function getInterface($nsRoot = null)
    {
        if(!$interfacePath = Config::getInterfacePath()){
            throw new Exception('接口文件保存路径未配置!');
        }

        $token = Config::getToken();

        $params = [$nsRoot, $token];
        if($res = $this->client->invoke('getInterface', $params)){
            $saveFile = $interfacePath . 'arch.zip';
            file_put_contents($saveFile, $res);
            $zip = new Zipper();
            if($zip->open($saveFile) !== true) {
                throw new Exception('接口文件解压失败!');
            }

            $zip->extractTo($interfacePath);
            $zip->close();
            unlink($saveFile);
        }
    }
}