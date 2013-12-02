<?php
/**
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Tests\Profiler;

use So\LogboardBundle\Profiler\Counter;
use So\LogboardBundle\Tests\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CounterTest
 * @package So\LogboardBundle\Tests\Profiler
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class CounterTest extends WebTestCase
{

    private $counter;
    private $refinedData;

    /**
     *
     */
    protected function setUp()
    {
        $this->counter = new Counter();
        $dataProvider = new DataProvider();
        $this->refinedData = $dataProvider->refinedDataWithPriorityKey();
    }

    public function testHandlerWithData()
    {

        $this->counter->handle($this->refinedData);

        $countedData = $this->counter->getCountedData();
        $debug = $countedData['DEBUG']['count'];
        $info = $countedData['INFO']['count'];
        $error = $countedData['ERROR']['count'];

        $this->assertObjectHasAttribute('data', $this->counter);
        $this->assertObjectHasAttribute('countedData', $this->counter);
        $this->assertEquals(18, $debug);
        $this->assertEquals(1, $info);
        $this->assertEquals(1, $error);
        $this->assertCount(3, $countedData);
    }

    public function testHandlerNull()
    {
        $data = array();

        $this->counter->handle($data);
        $countedData = $this->counter->getCountedData();
        $data = $this->counter->getData();

        $this->assertObjectHasAttribute('data', $this->counter);
        $this->assertObjectHasAttribute('countedData', $this->counter);

        $this->assertEmpty($countedData);
        $this->assertEmpty($data);
    }
}