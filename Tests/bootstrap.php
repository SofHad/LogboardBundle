<?php
$sfAutoload = __DIR__ . '/../app/vendor/autoload.php';
$bundleAutoload = __DIR__ . '/../vendor/autoload.php';

$autoload = require_once $sfAutoload;

$loader->add('Vendor_', '/');

// look for Vendor\Package classes in this path:
$loader->add('So', __DIR__ . '/../../');

$loader->register();

//
//if (file_exists($sfAutoload)) {
//    $autoload = require_once $sfAutoload;
//} elseif (file_exists($bundleAutoload)) {
//    $autoload = require_once $bundleAutoload;
//} else {
//    throw new RuntimeException('Install dependencies to run test suite.');
//}
