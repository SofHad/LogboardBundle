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

/**
 * Counter Test
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class CounterTest extends \PHPUnit_Framework_TestCase {

    private $counter;

    protected function setUp(){
        $this->counter = new Counter();
    }


    public function testHandlerWithData(){

        $data = $this->getData();

        $this->counter->handle($data);

        $countedData = $this->counter->getCountedData();
        $debug = $countedData['DEBUG']['count'];
        $info  = $countedData['INFO']['count'];

        $this->assertObjectHasAttribute('data', $this->counter);
        $this->assertObjectHasAttribute('countedData', $this->counter);
        $this->assertEquals(3, $debug);
        $this->assertEquals(2, $info);
    }

    public function testHandlerNull(){

        $data = array();

        $this->counter->handle($data);
        $countedData = $this->counter->getCountedData();
        $data = $this->counter->getData();

        $this->assertObjectHasAttribute('data', $this->counter);
        $this->assertObjectHasAttribute('countedData', $this->counter);

        $this->assertEmpty($countedData);
        $this->assertEmpty($data);
    }

    public function getData(){
        $data = array();
        $data[] = array(
            'key' => 'DEBUG',
            'value' => 'Notified event "kernel.request" to listener "Symfony\Component\HttpKernel\EventListener\ProfilerListener::onKernelRequest"'
        );

        $data[] = array(
            'key' => 'DEBUG',
            'value' => 'Notified event "kernel.request" to listener "Symfony\Component\HttpKernel\EventListener\ProfilerListener::onKernelRequest"'
        );

        $data[] = array(
            'key' => 'DEBUG',
            'value' => 'Notified event "kernel.response" to listener "Symfony\Bridge\Monolog\Handler\FirePHPHandler::onKernelResponse"'
        );

        $data[] = array(
            'key' => 'INFO',
            'value' => ' Matched route "_welcome" (parameters: "_controller": "Acme\DemoBundle\Controller\WelcomeController::indexAction", "_route": "_welcome")'
        );

        $data[] = array(
            'key' => 'INFO',
            'value' => ' Matched route "_welcome" (parameters: "_controller": "Acme\DemoBundle\Controller\WelcomeController::indexAction", "_route": "_welcome")'
        );

        return $data;
    }
}