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


use So\LogboardBundle\Exception\NotFoundHttpException;
use So\LogboardBundle\Profiler\QueryManager;
use So\LogboardBundle\Tests\DataProvider;
use So\LogboardBundle\Tests\KernelTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Profiler\FileProfilerStorage;
use Symfony\Component\HttpKernel\Profiler\Profiler;


abstract class QueryManagerTest extends KernelTest
{

    protected $request;
    protected $token;
    protected $queryManager;
    protected $profilerTest;
    protected $panel;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $dataProvider = new DataProvider();

        //Create queryManager
        $router = $this->container->get("router");
        $this->panel = $this->container->getParameter('logboard.panel');
        $defaultChart = $this->container->getParameter('logboard.default_chart');
        $index = $dataProvider->indexForQueryManager();

        $this->queryManager = new QueryManager($router, $this->panel, $defaultChart, $index);
    }

    public function testInitializationQueryManager()
    {
        $this->assertObjectHasAttribute('router', $this->queryManager);
        $this->assertObjectHasAttribute('panel', $this->queryManager);
        $this->assertObjectHasAttribute('defaultChart', $this->queryManager);
        $this->assertObjectHasAttribute('index', $this->queryManager);
    }

    public function findData()
    {
        $this->request = new Request();
        $this->request->attributes->set('_route', '_profiler');

        $storage = new FileProfilerStorage($this->getDsn());

        //create profilerTest
        $this->profilerTest = new Profiler($storage);
        

        return  $this->profilerTest->find(null, null, 1, null, 0, null);
    }


    public function testHandleQueriesForEmptyEngine()
    {
        $found = $this->findData();

        $this->assertTrue(is_array($found));
        $this->assertCount(1, $found);
        $this->assertArrayHasKey("token", $found[0]);

        //447c8d
        $this->token = $found[0]["token"];
        $this->queryManager->handleQueries($this->request, $this->token);

        $this->assertObjectHasAttribute("isChartSubmitted", $this->queryManager);
        $this->assertObjectHasAttribute("engineSwitcherUrl", $this->queryManager);
        $this->assertObjectHasAttribute("iconSwitcherUrl", $this->queryManager);

        $this->assertFalse($this->queryManager->hasEngine());
    }

    public function getDsn(){

        $file = "/index.csv";
        $dsn = sprintf('%s/../cache.profiler/', __DIR__);

        if (file_exists($dsn.$file)) {
            return sprintf('file:%s', $dsn);
        }

        throw new NotFoundHttpException('There is no token in the "%s" directory', $dsn);
    }


}