<?php

use PHPUnit\Framework\TestCase;
use qxb\cicada\Config;
use qxb\cicada\Scanner;

class ScannerTest extends TestCase
{
    public function testScanPath()
    {
        $scanner = new Scanner();

        $tmpPath = "/tmp/cicada";
        if (!is_writable($tmpPath)) {
            $this->assertTrue(false, $tmpPath . ' not have write permissions');
        }

        $tmpPath = sprintf("%s/%s", $tmpPath, mt_rand(100000, 999999));
        mkdir($tmpPath);
        $scanner->scanPath('./clazz', '\\clazz', $tmpPath);
        $this->assertTrue(true);
        $scanner->archDir($tmpPath, "/tmp/cicada/zip.zip");
        $this->assertTrue(file_exists("/tmp/cicada/zip.zip"));
    }

    public function testScanRPC()
    {
        Config::addScanPackage('./clazz', '\\clazz');
        $server = new Scanner();
        $server->scanRpc();
        $this->assertTrue(true);
    }
}