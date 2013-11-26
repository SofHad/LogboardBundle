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

<<<<<<< HEAD
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
=======
$kernelClass =  __DIR__ . '/app/AppKernel.php';

if(!file_exists($kernelClass)){
    throw new \LogicException(sprintf('Could not find "%s"', $kernelClass));
}

require_once $kernelClass;
>>>>>>> d2

/**
 * KernelTest
 */
abstract class KernelTest extends WebTestCase
{
    /**
     * @var \Symfony\Component\HttpKernel\AppKernel
     */
<<<<<<< HEAD
    protected $kernelTest;

=======
    protected $kernel;
>>>>>>> d2
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @return void
     */
    public function setUp()
    {
<<<<<<< HEAD
        if (null !== static::$kernel) {
            static::$kernel->shutdown();
        }
=======
        $this->kernel = new \AppKernel('test', true);
        $this->kernel->boot();

        $this->container = $this->kernel->getContainer();

        parent::setUp();
    }
>>>>>>> d2


        $this->container = static::$kernel->getContainer();
    }
}
