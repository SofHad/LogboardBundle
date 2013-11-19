<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Tests\Profiler\Engine;


use So\LogboardBundle\Profiler\Engine\FileStorageEngine;
use So\LogboardBundle\Profiler\Parameter\ProfilerFinderParameters;
use So\LogboardBundle\Tests\KernelTest;
use Symfony\Component\HttpKernel\Profiler\Profiler;

class FileStorageEngineTest extends KernelTest {

    private $fileStorageEngine;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $profiler = $this->container->getParameter('profiler');
        $finder = $this->container->get('logboard.profiler_finder_parameters.class');
        $parameters = new ProfilerFinderParameters(30000000, "logger");
        $this->fileStorageEngine = new FileStorageEngine($profiler, $finder, $parameters);
    }

    public function testFindProfile(){
        $data = $this->fileStorageEngine->find(null);
    }



} 