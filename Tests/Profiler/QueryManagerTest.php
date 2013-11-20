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


abstract class QueryManagerTest extends KernelTest
{

    protected $request;
    protected $token;
    protected $queryManager;
    protected $profiler;
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
        $appDir = $this->container->getParameter("kernel.root_dir");

        $finder = new FileProfilerStorage($this->getDsn($appDir));
        return $finder->find(null, null, 1, null, 0, null);
    }


    public function testHandleQueriesForEmptyEngineEngine()
    {
        $found = $this->findData();
        $this->assertTrue(is_array($found));
        $this->assertCount(1, $found);
        $this->assertArrayHasKey("token", $found[0]);

        $this->token = $found[0]["token"];
        $this->queryManager->handleQueries($this->request, $this->token);

        $this->assertObjectHasAttribute("isChartSubmitted", $this->queryManager);
        $this->assertObjectHasAttribute("engineSwitcherUrl", $this->queryManager);
        $this->assertObjectHasAttribute("iconSwitcherUrl", $this->queryManager);

        $this->assertFalse($this->queryManager->hasEngine());
    }

    public function getDsn($appDir){

        $file = "/index.csv";
        $devDsn = sprintf('%s/cache/dev/profiler', $appDir);
        $testDsn = sprintf('%s/cache/test/profiler', $appDir);
        $prodDsn = sprintf('%s/cache/prod/profiler', $appDir);

        if (file_exists($devDsn.$file)) {
            $dsn = sprintf('file:%s', $devDsn);
        } elseif ($testDsn.$file) {
            $dsn = sprintf('file:%s', $testDsn);
        } elseif ($prodDsn.$file) {
            $dsn = sprintf('file:%s', $prodDsn);
        }else{
            throw new NotFoundHttpException("There is no token in the cache directory");
        }

        return $dsn;
    }


}