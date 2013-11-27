<?php
require_once('PHPUnit/Autoload.php');

require '../src/So/LogboardBundle/vendor/autoload.php';

$profilerManagerTest = new \So\LogboardBundle\Tests\Profiler\ProfilerManagerTest();
$profilerManagerTest->setUp();
$profilerManagerTest->testGetCollector();


 //DUMP---------------------------------
         include_once 'debug/Kint.class.php';
         \kint::dump($profilerManagerTest) ;
         echo "</pre>";
         exit ;
 //DUMP---------------------------------


?>