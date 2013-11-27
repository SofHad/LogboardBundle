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
 * Class FileStorageParametersTest
 *
 * @package So\LogboardBundle\Tests\Profiler\Parameter
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class FileStorageParametersTest extends KernelTest
{
    public function testGetParameters()
    {
        $this->setUp();

        $filesystem = $this->container->get('filesystem');
        $file = sprintf('%s/dev.log', $this->container->getParameter('kernel.logs_dir'));
        $fileStorageParameters = new FileStorageParameters($filesystem, $file);
        $parameters = $fileStorageParameters->getParameters(null);

        $this->assertCount(2, $parameters);
        $this->assertArrayHasKey('filesystem', $parameters);
        $this->assertArrayHasKey('data', $parameters);
        $this->assertObjectHasAttribute('filesystem', $fileStorageParameters);
        $this->assertObjectHasAttribute('file', $fileStorageParameters);
        $this->assertFileExists($file);
    }
}