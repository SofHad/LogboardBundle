<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Tests\Profiler;


use So\LogboardBundle\Profiler\Engine\Decompiler\PatternMatcher;
use So\LogboardBundle\Profiler\Engine\FileStorageEngine;
use So\LogboardBundle\Profiler\Engine\Finder\FileStorageFinder;
use So\LogboardBundle\Profiler\Parameter\FileStorageParameters;
use So\LogboardBundle\Profiler\QueryManager;
use So\LogboardBundle\Tests\DataProvider;
use So\LogboardBundle\Tests\KernelTest;
use Symfony\Component\HttpFoundation\Request;


class ProfilerManagerTest extends KernelTest {

    private $fileStorageEngine;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    public function testLoadProfilesForProfilerManager(){

        $dataProvider = new DataProvider();

        //Create queryManager
        $router = $this->container->get("router");
        $panel = $this->container->getParameter('logboard.panel');
        $defaultChart = $this->container->getParameter('logboard.default_chart');
        $index = $dataProvider->indexForQueryManager();

        $queryManager = new QueryManager($router, $panel, $defaultChart, $index);
        $this->assertObjectHasAttribute('router', $queryManager);
        $this->assertObjectHasAttribute('panel', $queryManager);
        $this->assertObjectHasAttribute('defaultChart', $queryManager);
        $this->assertObjectHasAttribute('index', $queryManager);

        //Request
        $request = Request::createFromGlobals();




//         $dataProvider = new DataProvider();
//
//         $profiler = $this->container->get('profiler');
//         $patternMatcher = new PatternMatcher($dataProvider::SYMFONY_PATTERN_DATE);
//         $this->assertObjectHasAttribute('pattern', $patternMatcher);
//
//        //Finder
//         $finder = new FileStorageFinder($patternMatcher, null);
//         $this->assertObjectHasAttribute('callback', $finder);
//         $this->assertObjectHasAttribute('decompiler', $finder);
//
//        //LogFile
//        $logFileForTests = sprintf("%s/../../%s", __DIR__, $dataProvider::TESTS_LOG_FILE);
//        $this->assertFileExists($logFileForTests);
//
//        //Parameters
//        $filesystem = $this->container->get('filesystem');
//        $parameters = new FileStorageParameters($filesystem, $logFileForTests);
//        $this->assertObjectHasAttribute('filesystem', $parameters);
//        $this->assertObjectHasAttribute('file', $parameters);
//
//        //Engine
//        $fileStorageEngine = $this->fileStorageEngine = new FileStorageEngine($profiler, $finder, $parameters);
//        $this->assertObjectHasAttribute('parametersHandler', $fileStorageEngine);
//        $this->assertObjectHasAttribute('profiler', $fileStorageEngine);
//        $this->assertObjectHasAttribute('finder', $fileStorageEngine);
//
//        $profiles = $fileStorageEngine->loadProfiles();
//        $this->assertCount(20, $profiles);
//        $this->assertArrayHasKey('key', $profiles[0]);
//        $this->assertArrayHasKey('value', $profiles[0]);
//
//        $this->assertEquals('2013-10-11', $profiles[0]['key']);
//        $this->assertContains('Notified event "kernel.controller" to listener "Symfony\Bundle\FrameworkBundle\DataCollector\RouterDataCollector::onKernelController"', $profiles[0]['value']);
    }



} 