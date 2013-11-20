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

    public function initializeProfilerManager(){

        parent::setUp();

        $this->testHandleQueriesForEmptyEngine();

        $counter = new Counter();

        $this->profilerManager = new ProfilerManager($counter, $this->profilerTest, $this->panel);
    }

   public function testInitializationProfilerManagerForEmptyEngine(){

       $this->initializeProfilerManager();

       $this->assertObjectHasAttribute("collector", $this->profilerManager);

       $this->profilerManager->loadProfiles($this->queryManager);

       $this->assertObjectHasAttribute('countedData', $this->profilerManager);
   }

}