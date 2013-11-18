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

use So\LogboardBundle\Profiler\DataResolver;

/**
 * Data Resolver Test
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class DataResolverTest extends \PHPUnit_Framework_TestCase {

    public function testRefine(){

        $collections[0] = array(
            "timestamp"   => '1384807747',
            "message"     => 'Notified event "kernel.request" to listener "Symfony\Bundle\FrameworkBundle\EventListener\SessionListener::onKernelRequest',
            "priority" =>  '',
            "priorityName"=> 'DEBUG',
            "context" => array()
        );

        $data = DataResolver::refine($collections);

        $this->assertArrayHasKey('key', $data[0]);
        $this->assertArrayHasKey('value', $data[0]);
        $this->assertEquals("DEBUG", $data[0]['key']);
        $this->assertTrue(2 === count( $data[0]));
    }
}