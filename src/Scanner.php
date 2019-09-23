<?php


namespace qxb\cicada;


use com\github\gooh\InterfaceDistiller\InterfaceDistiller;
use Exception;
use ReflectionMethod;
use SplFileObject;
use ZipArchive;

class Scanner
{
    /**
     * 扫描生成接口文件
     * @param string|null $nsRoot 指定新的命名空间根目录
     * @throws Exception
     */
    public function scanRpc($nsRoot = null)
    {
        $scanPath = Config::getScanPackage();
        $savePath = Config::getTempPath();

        if (empty($scanPath)) return;

        $this->clearSavePath($savePath);
        foreach ($scanPath as $package) {
            $realSavePath = sprintf("%s/%s", $savePath, str_replace('\\', '/', $nsRoot));
            $this->scanPath($package['path'], $package['namespace'], $realSavePath, $nsRoot);
        }

        $this->archDir($savePath, $savePath . '/arch.zip');
    }

    /**
     * 生成接口文件
     * @param string $fromPath 扫描路径
     * @param string $fromNamespace 命名空间
     * @param string $savePath 生成的接口文件保存路径
     * @param string|null $toNamespace 生成的接口文件的命名空间
     * @throws Exception
     */
    public function scanPath($fromPath, $fromNamespace, $savePath, $toNamespace = null)
    {
        if (!file_exists($savePath)) {
            if (!mkdir($savePath, 0777, true)) throw new Exception('mkdir path ' . $savePath . ' failure');
        }

        $distiller = new InterfaceDistiller();
        if ($handle = opendir($fromPath)) {
            while (false !== ($file = readdir($handle))) {
                if ($file == '.' || $file == '..') continue;
                if (is_dir($fromPath . '/' . $file)) {
                    $this->scanPath($fromPath . '/' . $file, $fromNamespace . '\\' . $file, $savePath . '/' . $file, $toNamespace);
                } else {
                    $pathInfo = pathinfo($file);
                    if ($pathInfo['extension'] == 'php') {
                        $toClsName = str_replace('.class', '', $pathInfo['filename']);
                        $fromCls = sprintf('%s\\%s', $fromNamespace, $toClsName);
                        $toClsWithNs = sprintf('%s\\%s\\%s', $toNamespace, $fromNamespace, $toClsName);

                        $distiller
                            ->methodsWithModifiers(ReflectionMethod::IS_PUBLIC)
                            ->extendInterfaceFrom('Iterator, SeekableIterator')
                            ->excludeImplementedMethods()
                            ->excludeInheritedMethods()
                            ->excludeMagicMethods()
                            ->excludeOldStyleConstructors()
                            ->filterMethodDocByPattern(Config::getMatchMethodTag())
                            ->filterClassDocByPattern(Config::getMatchClassTag())
                            ->saveAs(new SplFileObject(sprintf("%s/%s.php", $savePath, $toClsName), 'w'))
                            ->distill($fromCls, $toClsWithNs);
                        $distiller->reset();
                    }
                }
            }
        }
    }

    /**
     * 压缩接口目录
     * @param string $dir 接口所在目录
     * @param string $target 打包到目录
     * @return bool
     */
    public function archDir($dir, $target)
    {
        $zipper = new Zipper();
        if ($zipper->open($target, ZipArchive::CREATE) !== true) {
            return false;
        }
        $zipper->addDir($dir);
        $zipper->close();

        return true;
    }

    private function clearSavePath($dirname)
    {
        if (is_dir($dirname)) $dirHandle = opendir($dirname);
        if (empty($dirHandle)) return false;

        while ($file = readdir($dirHandle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file))
                    unlink($dirname . "/" . $file);
                else
                    $this->clearSavePath($dirname . '/' . $file);
            }
        }
        closedir($dirHandle);
        return true;
    }
}