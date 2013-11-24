<?php
$sfAutoload = __DIR__ . '/../app/vendor/autoload.php';
$bundleAutoload = __DIR__ . '/../vendor/autoload.php';


if (file_exists($sfAutoload)) {
    $autoload = require_once $sfAutoload;
} elseif (file_exists($bundleAutoload)) {
    $autoload = require_once $bundleAutoload;
} else {
    throw new RuntimeException('Install dependencies to run test suite.');
}
