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

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * KernelTest
 */
abstract class KernelTest extends WebTestCase
{
    /**
     * @var \Symfony\Component\HttpKernel\AppKernel
     */
    protected $kernelTest;

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @return void
     */
    public function setUp()
    {
        if (null !== static::$kernel) {
            static::$kernel->shutdown();
        }
//DUMP--------------------------
require_once 'Kint.class.php';
\Kint::dump($this->createKernel());
exit ;
//DUMP--------------------------

        $this->container = static::$kernel->getContainer();
    }
}
