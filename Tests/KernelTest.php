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

$file = __DIR__ . '/../vendor/symfony/app/AppKernel.php';

if (!file_exists($file)) {

    if ($handle = opendir( __DIR__ . '/../vendor/symfony/')) {
        echo "Gestionnaire du dossier : $handle\n";
        echo "Entrées :\n";

        /* Ceci est la façon correcte de traverser un dossier. */
        while (false !== ($entry = readdir($handle))) {
            echo "$entry\n";
        }

        /* Ceci est la MAUVAISE façon de traverser un dossier. */
        while ($entry = readdir($handle)) {
            echo "$entry\n";
        }

        closedir($handle);
    }

    throw new \RuntimeException('Install dependencies to run test suite.');
}

require_once $file ;

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
