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

use So\LogboardBundle\Tests\DataProvider;
use So\LogboardBundle\Tests\KernelTest;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class ProfilerManagerTest
 *
 * @package So\LogboardBundle\Tests\Profiler
 */
class ProfilerManagerTest extends KernelTest
{
    protected $profilerManager;
    protected $profilerMock;
    protected $profilerManagerMock;
    protected $panel;
    protected $counter;
    protected $queryManagerMock;
    protected $profileMock;

    public function setUp()
    {
        parent::setUp();

        $this->panel = $this->container->getParameter('logboard.panel');
        $this->counter = $this->container->get('logboard.counter');

        $this->profilerMock = $this->getMockBuilder('Symfony\Component\HttpKernel\Profiler\Profiler')
            ->disableOriginalConstructor()
            ->getMock();

        $this->profilerManagerMock = $this->getMockBuilder('So\LogboardBundle\Profiler\ProfilerManager')
            ->setMethods(array('getPanel'))
            ->enableOriginalConstructor()
            ->setConstructorArgs(
                array(
                    $this->counter,
                    $this->profilerMock,
                    $this->panel
                )
            )
            ->getMock();

        $this->queryManagerMock = $this->getMockBuilder('So\LogboardBundle\Profiler\QueryManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->profileMock = $this->getMockBuilder('Symfony\Component\HttpKernel\Profiler\Profile')
            ->disableOriginalConstructor()
            ->getMock();

       $this->profilerManagerMock->setProfile($this->profileMock);

    }

    public function setCollectorStatus($value){
        $this->profileMock->expects($this->any())
            ->method('hasCollector')
            ->with($this->anything())
            ->will($this->returnValue($value));
    }

    public function testProfilerManagerHasCollectorIsEquivalentToProfileHasCollector()
    {
        $value=true;
        $this->setCollectorStatus($value);
        $this->assertEquals($value, $this->profilerManagerMock->hasCollector());

        $this->setCollectorStatus(!$value);
        $this->assertEquals(!$value, !$this->profilerManagerMock->hasCollector());
    }

    public function testThrowException()
    {
        $this->profilerManagerMock->setProfile(null);
        $this->setExpectedException('\So\LogboardBundle\Exception\InvalidArgumentException');
        $this->profilerManagerMock->hasCollector();
    }

    public function testLoadProfiles()
    {
        $this->queryManagerMock->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue(DataProvider::TOKEN));

        $this->profilerManagerMock->expects($this->any())
            ->method('getProfile')
            ->will($this->returnValue(null));
    }


}