<?php
/**
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Tests;

$kernelClass =  __DIR__ . '/app/AppKernel.php';

if(!file_exists($kernelClass)){
    throw new \LogicException(sprintf('Could not find "%s"', $kernelClass));
}

require_once $kernelClass;

/**
 * KernelTest
 */
abstract class KernelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\HttpKernel\AppKernel
     */
    protected $kernel;
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->kernel = new \AppKernel('test', true);
        $this->kernel->boot();

        $this->container = $this->kernel->getContainer();

        parent::setUp();
    }

    /**
     * @return void
     */
    public function tearDown()
    {
        $this->kernel->shutdown();

        parent::tearDown();
    }
}
