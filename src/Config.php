<?php
namespace qxb\cicada;

class Config
{
    /** @var string 应用名 */
    private static $appName;
    /** @var string 注册中心 */
    private static $registry;
    /** @var string 服务端 */
    private static $server;
    /** @var array 需要扫描生成接口的路径  */
    private static $scanPackage = [];
    /** @var string 生成的接口文件保存临时目录 */
    private static $tempPath = '/tmp/cicada';
    /** @var string 作为客户端时,接口文件保存目录 */
    private static $interfacePath = '';
    /** @var string 通讯密钥 */
    private static $token = '';

    /**
     * 注册中心
     * @return string
     */
    public static function getRegistry()
    {
        return self::$registry;
    }

    /**
     * 注册中心
     * @param string $registry
     */
    public static function setRegistry($registry)
    {
        self::$registry = $registry;
    }

    /**
     * @return string
     */
    public static function getServer()
    {
        return self::$server;
    }

    /**
     * @param string $server
     */
    public static function setServer($server)
    {
        self::$server = $server;
    }

    /**
     * @return string
     */
    public static function getAppName()
    {
        return self::$appName;
    }

    /**
     * @param string $appName
     */
    public static function setAppName($appName)
    {
        self::$appName = $appName;
    }

    /**
     * @return array
     */
    public static function getScanPackage()
    {
        return self::$scanPackage;
    }

    /**
     * @param array $scanPackage
     */
    public static function setScanPackage($scanPackage)
    {
        self::$scanPackage = $scanPackage;
    }

    public static function addScanPackage($path, $namespace) {
        self::$scanPackage[] = ['path' => $path, 'namespace' => $namespace];
    }

    /**
     * @return string
     */
    public static function getTempPath()
    {
        return self::$tempPath;
    }

    /**
     * @param string $tempPath
     */
    public static function setTempPath($tempPath)
    {
        self::$tempPath = $tempPath;
    }

    /**
     * @return string
     */
    public static function getToken()
    {
        return self::$token;
    }

    /**
     * @param string $token
     */
    public static function setToken($token)
    {
        self::$token = $token;
    }

    /**
     * @return string
     */
    public static function getInterfacePath()
    {
        return self::$interfacePath;
    }

    /**
     * @param string $interfacePath
     */
    public static function setInterfacePath($interfacePath)
    {
        self::$interfacePath = $interfacePath;
    }
}