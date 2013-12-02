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

use So\LogboardBundle\Tests\DataProvider;
use So\LogboardBundle\Tests\KernelTest;

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

    public function setUp()
    {
        parent::setUp();

        $this->profiler = $this->container->get('profiler');
        $this->panel = $this->container->getParameter('logboard.panel');
        $this->counter = $this->container->get('logboard.counter');

        $this->profilerManager = $this->container->get('logboard.profiler_manager');

        $this->profilerManager = $this->getMockBuilder('So\LogboardBundle\Profiler\ProfilerManager')
            ->setMethods(array('loadProfiles'))
            ->enableOriginalConstructor()
            ->setConstructorArgs(
                array(
                    $this->counter,
                    $this->profiler,
                    $this->panel
                )
            )
            ->getMock();
    }

    public function testLoadProfiles()
    {
        $queryManager = $this->getMockBuilder('So\LogboardBundle\Profiler\QueryManager')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $queryManager->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue(DataProvider::TOKEN))
        ;

     $this->profilerManager->loadProfiles($queryManager);
    }
}