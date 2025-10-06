<?php

use Src\Core\Application;

$start_framework = microtime(true);

if (PHP_MAJOR_VERSION < 8) {
    die('Require PHP version is 8.0+');
}

require_once __DIR__ . '/../src/Config/Config.php';

require_once realpath(APP_PATH . '/../vendor/autoload.php') ;

require_once realpath(HELPER . '/Helpers.php') ;

$app = new Application();

require_once realpath(APP_PATH . '/Routes/Routes.php') ;

$app->run();