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

/**
 * Class ProfilerManagerTest
 *
 * @package So\LogboardBundle\Tests\Profiler
 */
class ProfilerManagerTest extends KernelTest
{
    protected $profilerManager;
    protected $profiler;
    protected $profilerManagerMock;
    protected $panel;
    protected $counter;
    protected $queryManagerMock;
    protected $profile;

    public function setUp()
    {
        parent::setUp();

        //$this->profiler = $this->container->get('profiler');
        $this->panel = $this->container->getParameter('logboard.panel');
        $this->counter = $this->container->get('logboard.counter');

        $this->profiler = $this->getMockBuilder('Symfony\Component\HttpKernel\Profiler\Profiler')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->profilerManagerMock = $this->getMockBuilder('So\LogboardBundle\Profiler\ProfilerManager')
           ->setMethods(array('getPanel'))
            ->enableOriginalConstructor()
            ->setConstructorArgs(
                array(
                    $this->counter,
                    $this->profiler,
                    $this->panel
                )
            )
            ->getMock()
        ;

        $this->profilerManagerMock->expects($this->any())
            ->id("data")
            ->will($this->returnValue(array(1,2,3)))
        ;

        $this->queryManagerMock = $this->getMockBuilder('So\LogboardBundle\Profiler\QueryManager')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->profilerManagerMock->expects($this->any())
            ->method('getProfile')
            ->will($this->returnValue(null))
        ;

        $this->profiler->expects($this->any())
            ->method('loadProfile')
            ->with($this->anything())
            ->will($this->returnValue("test"))
         ;
    }

    public function testLoadProfiles()
    {
        $this->queryManagerMock->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue(DataProvider::TOKEN))
        ;

        $this->profilerManagerMock->expects($this->any())
            ->method('getProfile')
            ->will($this->returnValue(null))
        ;
    }


}