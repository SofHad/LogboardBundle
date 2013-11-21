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

class ProfilerManagerTest extends QueryManagerTest
{
    protected $profilerManager;

    public function setUp()
    {
        parent::setUp();

        $this->initializeProfilerManager();

        $this->loadProfiles();
    }

    public function initializeProfilerManager()
    {
        $counter = new Counter();

        $this->profilerManager = new ProfilerManager($counter, $this->profilerTest, $this->panel);
    }

    public function testInitializationProfilerManagerForEmptyEngine()
    {
        $this->assertObjectHasAttribute("collector", $this->profilerManager);
    }

    public function loadProfiles()
    {
        $this->profilerManager->loadProfiles($this->queryManager);
    }

    public function testProfilesLoaded()
    {
        $countedData = $this->profilerManager->getCountedData();
        $this->assertObjectHasAttribute('countedData', $this->profilerManager);

        $this->assertArrayHasKey('DEBUG', $countedData);
        $this->assertEquals(27, $countedData["DEBUG"]["count"]);

        $this->assertArrayHasKey('INFO', $this->profilerManager->getCountedData());
        $this->assertEquals(1, $countedData["INFO"]["count"]);
    }

}