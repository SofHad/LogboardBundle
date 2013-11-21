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


class QueryManagerTest extends KernelTest
{

    protected $request;
    protected $token;
    protected $queryManager;
    protected $profilerTest;
    protected $panel;
    protected $found;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->queryManagerInitialization();

        $this->findData();

        $this->HandleQueries();
    }

    public function queryManagerInitialization()
    {
        $dataProvider = new DataProvider();

        //Create queryManager
        $router = $this->container->get("router");
        $this->panel = $this->container->getParameter('logboard.panel');
        $defaultChart = $this->container->getParameter('logboard.default_chart');
        $index = $dataProvider->indexForQueryManager();

        $this->queryManager = new QueryManager($router, $this->panel, $defaultChart, $index);
    }

    public function findData()
    {
        $this->request = new Request();
        $this->request->attributes->set('_route', '_profiler');

        //create profilerTest
        $storage = new FileProfilerStorage($this->getDsn());
        $this->profilerTest = new Profiler($storage);

        $this->found = $this->profilerTest->find(null, null, 1, null, 0, null);
    }

    public function HandleQueries(){
        $this->token = $this->found[0]["token"];
        $this->queryManager->handleQueries($this->request, $this->token);
    }

    public function testQueryManagerInitialization()
    {
        $this->assertObjectHasAttribute('router', $this->queryManager);
        $this->assertObjectHasAttribute('panel', $this->queryManager);
        $this->assertObjectHasAttribute('defaultChart', $this->queryManager);
        $this->assertObjectHasAttribute('index', $this->queryManager);
    }

    public function testFoundData()
    {
        $this->assertTrue(is_array($this->found));
        $this->assertCount(1, $this->found);
        $this->assertArrayHasKey("token", $this->found[0]);

    }

    public function testTheResultAfterHandlingQueries(){
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

        throw new NotFoundHttpException('The resource index.csv file not found in the "%s" directory.', $dsn);
    }


}