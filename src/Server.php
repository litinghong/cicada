<?php

namespace qxb\cicada;

use Exception;

class Server
{
    /** @var \Hprose\Http\Server */
    private $server;
    /** @var string 密钥 */
    private $token = '';

    /**
     * @throws Exception
     */
    public function start()
    {
        $this->server = new \Hprose\Http\Server();
        $this->server->addFunction([$this, 'entryPoint']);
        $this->server->addFunction([$this, 'getInterface']);
        $this->token = Config::getToken();
        $this->server->start();
    }

    /**
     * 唯一入口
     * @param string $class
     * @param string $method
     * @param mixed $args
     * @param string $token
     * @return array
     * @throws Exception
     */
    public function entryPoint($class, $method, $args, $token)
    {
        if(!$this->checkToken($token)) {
            throw new Exception('token error!');
        }

        if (!class_exists($class)) {
            throw new Exception(sprintf("class %s not found!", $class));
        }

        if (method_exists($class, 'getInstance')) {
            $clazz = $class::getInstance();
            return call_user_func_array([$clazz, $method], $args);
        } else {
            $clazz = new $class();
            return call_user_func_array([$clazz, $method], $args);
        }
    }

    /**
     * 返回接口文件
     * @param string $nsRoot
     * @param string $token
     * @return false|string
     * @throws Exception
     */
    public function getInterface($nsRoot, $token)
    {
        if(!$this->checkToken($token)) {
            throw new Exception('token error!');
        }

        $scanner = new Scanner();
        $scanner->scanRpc($nsRoot);

        $savePath = Config::getTempPath();
        return file_get_contents($savePath . '/arch.zip');
    }

    private function checkToken($token){
        return $this->token == $token;
    }
}