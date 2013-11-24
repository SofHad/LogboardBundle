<?php
$file = __DIR__.'/../../vendor/autoload.php';

if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}

$autoload = require_once $file;




//function includeIfExists($file)
//{
//    if (file_exists($file)) {
//        return include $file;
//    }
//}
//
//if ((!$loader = includeIfExists(__DIR__.'/../vendor/autoload.php')) && (!$loader = includeIfExists(__DIR__.'/../../../../../autoload.php'))) {
//    die('You must set up the project dependencies, run the following commands:'.PHP_EOL.
//        'curl -s http://getcomposer.org/installer | php'.PHP_EOL.
//        'php composer.phar install --dev'.PHP_EOL);
//}