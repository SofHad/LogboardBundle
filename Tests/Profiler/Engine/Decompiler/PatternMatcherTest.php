<?php
/**
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Tests\Profiler\Engine\Decompiler;

use So\LogboardBundle\Exception\InvalidArgumentException;
use So\LogboardBundle\Profiler\Engine\Decompiler\PatternMatcher;
use So\LogboardBundle\Tests\DataProvider;
use So\LogboardBundle\Tests\KernelTest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PatternMatcherTest
 *
 * @package So\LogboardBundle\Tests\Profiler\Engine\Decompiler
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class PatternMatcherTest extends KernelTest
{

    private $patternMatcherDate;
    private $patternMatcherPriority;

    public function setUp()
    {
        parent::setUp();
        $patternDate = DataProvider::SYMFONY_PATTERN_DATE;
        $patternPriority = DataProvider::SYMFONY_PATTERN_PRIORITY;
        $this->patternMatcherDate = new PatternMatcher($patternDate);
        $this->patternMatcherPriority = new PatternMatcher($patternPriority);
    }

    /**
     * @dataProvider Provider
     */
    public function testSplitDate($input)
    {
        $data = $this->patternMatcherDate->split($input);

        $this->assertObjectHasAttribute('pattern', $this->patternMatcherDate);
        $this->assertObjectHasAttribute('key', $this->patternMatcherDate);

        $this->assertArrayHasKey('key', $data);
        $this->assertArrayHasKey('value', $data);

        $this->assertEquals('2013-10-14', $data['key']);
        $this->assertEquals(str_replace("[]", null, $input), $data['value']);
    }

    /**
     * @dataProvider Provider
     */
    public function testSplitPriority($input)
    {
        $data = $this->patternMatcherPriority->split($input);

        $this->assertObjectHasAttribute('pattern', $this->patternMatcherPriority);
        $this->assertObjectHasAttribute('key', $this->patternMatcherPriority);

        $this->assertArrayHasKey('key', $data);
        $this->assertArrayHasKey('value', $data);

        $this->assertEquals('DEBUG', $data['key']);
        $this->assertEquals(str_replace("[]", null, $input), $data['value']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExceptionForPatternArgument()
    {
        $this->setExpectedException('InvalidArgumentException');

        new PatternMatcher(100);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExceptionForArgumentKey()
    {
        new PatternMatcher(DataProvider::SYMFONY_PATTERN_DATE, "String");
    }

    public function Provider()
    {
        return array(
            array('[2013-10-14 16:21:47] event.DEBUG: Notified event "kernel.controller" to listener "Symfony\Bundle\FrameworkBundle\DataCollector\RouterDataCollector::onKernelController". [] []'),
            array('[2013-10-14 16:21:47] event.DEBUG: Notified event "kernel.controller" to listener "Sensio\Bundle\FrameworkExtraBundle\EventListener\TemplateListener::onKernelController". [] []')
        );
    }
}