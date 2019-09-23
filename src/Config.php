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
    /** @var null|string 匹配类的Doc名 */
    private static $matchClassTag = null;
    /** @var null|string 匹配方法的Doc名 */
    private static $matchMethodTag = null;
    /** @var null|string 生成的文件后缀 */
    private static $saveFileSuffix = null;

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
     * 服务端
     * @return string
     */
    public static function getServer()
    {
        return self::$server;
    }

    /**
     * 服务端
     * @param string $server
     */
    public static function setServer($server)
    {
        self::$server = $server;
    }

    /**
     * 应用名
     * @return string
     */
    public static function getAppName()
    {
        return self::$appName;
    }

    /**
     * 应用名
     * @param string $appName
     */
    public static function setAppName($appName)
    {
        self::$appName = $appName;
    }

    /**
     * 需要扫描生成接口的路径
     * @return array
     */
    public static function getScanPackage()
    {
        return self::$scanPackage;
    }

    /**
     * 需要扫描生成接口的路径
     * @param array $scanPackage
     */
    public static function setScanPackage($scanPackage)
    {
        self::$scanPackage = $scanPackage;
    }

    /**
     * 需要扫描生成接口的路径
     * @param string $path 路径
     * @param string $namespace 路径所在的命名空间
     */
    public static function addScanPackage($path, $namespace) {
        self::$scanPackage[] = ['path' => $path, 'namespace' => $namespace];
    }

    /**
     * 生成的接口文件保存临时目录
     * @return string
     */
    public static function getTempPath()
    {
        return self::$tempPath;
    }

    /**
     * 生成的接口文件保存临时目录
     * @param string $tempPath
     */
    public static function setTempPath($tempPath)
    {
        self::$tempPath = $tempPath;
    }

    /**
     * 通讯密钥
     * @return string
     */
    public static function getToken()
    {
        return self::$token;
    }

    /**
     * 通讯密钥
     * @param string $token
     */
    public static function setToken($token)
    {
        self::$token = $token;
    }

    /**
     * 作为客户端时,接口文件保存目录
     * @return string
     */
    public static function getInterfacePath()
    {
        return self::$interfacePath;
    }

    /**
     * 作为客户端时,接口文件保存目录
     * @param string $interfacePath
     */
    public static function setInterfacePath($interfacePath)
    {
        self::$interfacePath = $interfacePath;
    }

    /**
     * 匹配类的Doc名
     * @return string|null
     */
    public static function getMatchClassTag()
    {
        return self::$matchClassTag;
    }

    /**
     * 匹配类的Doc名
     * @param string|null $matchClassTag
     */
    public static function setMatchClassTag($matchClassTag)
    {
        self::$matchClassTag = $matchClassTag;
    }

    /**
     * 匹配方法的Doc名
     * @return string|null
     */
    public static function getMatchMethodTag()
    {
        return self::$matchMethodTag;
    }

    /**
     * 匹配方法的Doc名
     * @param string|null $matchMethodTag
     */
    public static function setMatchMethodTag($matchMethodTag)
    {
        self::$matchMethodTag = $matchMethodTag;
    }

    /**
     * 生成的文件后缀
     * @return string|null
     */
    public static function getSaveFileSuffix()
    {
        return self::$saveFileSuffix;
    }

    /**
     * 生成的文件后缀
     * @param string|null $saveFileSuffix
     */
    public static function setSaveFileSuffix($saveFileSuffix)
    {
        self::$saveFileSuffix = $saveFileSuffix;
    }
}