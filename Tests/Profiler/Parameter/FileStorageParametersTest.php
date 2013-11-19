<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Tests\Profiler\Parameter;

use So\LogboardBundle\Profiler\Parameter\FileStorageParameters;
use So\LogboardBundle\Tests\KernelTest;

/**
 * Testing the FileStorageParameters class
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class FileStorageParametersTest extends KernelTest
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testGetParameters()
    {

        $filesystem = $this->container->get('filesystem');
        $file = __FILE__;
        $fileStorageParameters = new FileStorageParameters($filesystem, $file);
        $parameters = $fileStorageParameters->getParameters(null);

        $this->assertCount(2, $parameters);
        $this->assertArrayHasKey('filesystem', $parameters);
        $this->assertArrayHasKey('data', $parameters);
        $this->assertObjectHasAttribute('filesystem', $fileStorageParameters);
        $this->assertObjectHasAttribute('file', $fileStorageParameters);
    }

    /**
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }
}