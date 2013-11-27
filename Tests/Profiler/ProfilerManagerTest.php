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

use So\LogboardBundle\Profiler\Counter;
use So\LogboardBundle\Profiler\ProfilerManager;
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


    public function setUp()
    {
        parent::setUp();
        $this->profiler = $this->container->get('profiler');
        $this->panel = $this->container->getParameter('logboard.panel');
    }

    public function testGetCollector()
    {

        $collector = new \Symfony\Component\HttpKernel\DataCollector\LoggerDataCollector();

        $this->profilerManagerMock = $this->getMockBuilder('So\LogboardBundle\Profiler\ProfilerManagerInterface')
                                          ->setConstructorArgs(
                                                                array(
                                                                    $this->anything(array()),
                                                                    $this->profiler,
                                                                    $this->panel
                                                                )
                                                              )
                                           ->getMock()
        ;
        
        $this->profilerManagerMock->expects($this->any())
                                  ->method('getCollector')
        ;
        $collector = $this->profilerManagerMock->getCollector();
    }
}