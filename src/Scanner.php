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
     * @throws Exception
     */
    public function scanRpc()
    {
        $scanPath = Config::getScanPackage();
        $savePath = Config::getTempPath();

        if (empty($scanPath)) return;

        $this->clearSavePath($savePath);
        foreach ($scanPath as $package) {
            $this->scanPath($package['path'], $package['namespace'], $savePath);
        }

        $this->archDir($savePath, $savePath . '/arch.zip');
    }

    /**
     * 生成接口文件
     * @param string $scanPath 扫描路径
     * @param string $namespace 命名空间
     * @param string $savePath 生成的接口文件保存路径
     * @throws Exception
     */
    public function scanPath($scanPath, $namespace, $savePath)
    {
        if (!file_exists($savePath)) {
            if (!mkdir($savePath)) throw new Exception('mkdir path ' . $savePath . ' failure');
        }

        $distiller = new InterfaceDistiller();
        if ($handle = opendir($scanPath)) {
            while (false !== ($file = readdir($handle))) {
                if ($file == '.' || $file == '..') continue;
                if (is_dir($scanPath . '/' . $file)) {
                    $this->scanPath($scanPath . '/' . $file, $namespace . '\\' . $file, $savePath . '/' . $file);
                } else {
                    $pathInfo = pathinfo($file);
                    if ($pathInfo['extension'] == 'php') {
                        $clsName = str_replace('.class', '', $pathInfo['filename']);
                        $clsFullName = sprintf('%s\\%s', $namespace, $clsName);
                        $distiller
                            ->methodsWithModifiers(ReflectionMethod::IS_PUBLIC)
                            ->extendInterfaceFrom('Iterator, SeekableIterator')
                            ->excludeImplementedMethods()
                            ->excludeInheritedMethods()
                            ->excludeMagicMethods()
                            ->excludeOldStyleConstructors()
                            ->saveAs(new SplFileObject(sprintf("%s/%s.php", $savePath, $clsName), 'w'))
                            ->distill($clsFullName, $clsName);
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

    private function clearSavePath($dirname) {
        if (is_dir($dirname)) $dirHandle = opendir($dirname);
        if (empty($dirHandle)) return false;

        while($file = readdir($dirHandle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                    unlink($dirname."/".$file);
                else
                    $this->clearSavePath($dirname.'/'.$file);
            }
        }
        closedir($dirHandle);
        return true;
    }
}