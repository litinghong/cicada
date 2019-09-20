<?php
require_once './vendor/autoload.php';

use qxb\cicada\Config;
use qxb\cicada\Server;

Config::addScanPackage('tests/clazz', '\\clazz');
$server = new Server();
$server->start();
