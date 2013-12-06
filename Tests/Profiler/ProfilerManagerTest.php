<?php
/**
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Tests\Profiler;

use So\LogboardBundle\Profiler\ProfilerManager;
use So\LogboardBundle\Tests\DataProvider;
use So\LogboardBundle\Tests\KernelTest;
use Symfony\Component\Validator\Constraints\Null;

/**
 * Class ProfilerManagerTest
 *
 * @package So\LogboardBundle\Tests\Profiler
 *
 */
class ProfilerManagerTest extends KernelTest
{
    protected $profilerManager;
    protected $profiler;
    protected $panel;
    protected $counter;
    protected $queryManagerMock;
    protected $profile;
    protected $dataResolver;

    public function setUp()
    {
        parent::setUp();

        $this->profiler = $this
            ->getMockBuilder('Symfony\Component\HttpKernel\Profiler\Profiler')
            ->disableOriginalConstructor()
            ->getMock();

        $this->panel = $this->container->getParameter('logboard.panel');

        $this->counter = $this->container->get('logboard.counter');

        $this->profilerManager = new profilerManager(
            $this->counter, $this->profiler, $this->panel
        );

        $this->profilerManager->setToken(DataProvider::TOKEN);
        $this->profilerManager->setEngine(null);

        $this->queryManagerMock = $this
            ->getMockBuilder('So\LogboardBundle\Profiler\QueryManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->profilerManager->setQueryManager($this->queryManagerMock);

        $this->queryManagerMock->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue(DataProvider::TOKEN));

        $this->profiler->expects($this->any())
            ->method('loadProfile')
            ->with($this->anything())
            ->will($this->returnValue(
                    new \Symfony\Component\HttpKernel\Profiler\Profile(null))
            );

        $this->dataResolver = $this
            ->getMockBuilder('So\LogboardBundle\Profiler\DataResolver')
            ->getMock();

        $this->profile = $this
            ->getMockBuilder('Symfony\Component\HttpKernel\Profiler\Profile')
            ->disableOriginalConstructor()
            ->getMock();

        $this->profilerManager->setProfile($this->profile);
    }

    public function testProfilerManagerConstruction()
    {
        $this->assertObjectHasAttribute('counter', $this->profilerManager);
        $this->assertObjectHasAttribute('panel', $this->profilerManager);
        $this->assertObjectHasAttribute('collector', $this->profilerManager);
    }

    public function testGetProfile()
    {
        $this->setExpectedException(
            '\So\LogboardBundle\Exception\NotFoundHttpException'
        );

        $this->profilerManager->getProfile();
    }

    public function testCompile()
    {
        $this->profilerManager->setData(null);

        $this->profilerManager->setCollector(
            new \Symfony\Component\HttpKernel\DataCollector\LoggerDataCollector()
        );

        $this->profile->expects($this->any())
            ->method('getCollector')
            ->with($this->anything())
            ->will($this->returnValue(
                new \Symfony\Component\HttpKernel\DataCollector\LoggerDataCollector()
            ));

        $this->profilerManager->compile();

        $this->assertTrue(is_array($this->profilerManager->getData()));
    }

    public function testThrowExceptionForAggregateData()
    {
        $this->setExpectedException(
            '\So\LogboardBundle\Exception\BadQueryHttpException'
        );

        $this->profilerManager->aggregateData();
    }

    public function testAggregateDataWhenPreviewIsNotNull()
    {
        $this->queryManagerMock->expects($this->once())
            ->method("getPreview")
            ->will($this->returnValue("DEBUG"));

        $this->profilerManager->setData(DataProvider::refinedDataWithPriorityKey());

        $this->profilerManager->aggregateData();

        $this->assertCount(18, $this->profilerManager->getPreviewData());
    }

    public function testCountDataWhenTheDataIsNull(){
        $this->profilerManager->setData(null);

        $this->profilerManager->countData();

        $this->assertNull($this->profilerManager->getCountedData());
    }

    public function testCountDataWhenTheDataIsNotNull(){
        $this->profilerManager->setData(DataProvider::refinedDataWithPriorityKey());

        $this->profilerManager->countData();

        $countedData = $this->profilerManager->getCountedData();

        $this->assertEquals(
            18, (int)$countedData['DEBUG']['count']
        );
    }
}