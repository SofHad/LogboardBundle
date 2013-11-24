<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Tests;

$travis = __DIR__ . '/../app/app/AppKernel.php';
$standard = dirname(__DIR__) . '/../../../app/AppKernel.php';

if (file_exists($travis)) {
    require_once $travis;
} elseif (file_exists($standard)) {
    require_once $standard;
} else {
    throw new \RuntimeException('Install dependencies to run test suite.');
}


/**
 * Crea
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
