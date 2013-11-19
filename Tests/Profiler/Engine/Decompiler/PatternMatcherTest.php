<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Tests\Profiler\Engine\Decompiler;

use So\LogboardBundle\Profiler\Engine\Decompiler\PatternMatcher;
use So\LogboardBundle\Tests\KernelTest;

/**
 * Testing the PatternMatcher class
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class PatternMatcherTest extends KernelTest
{

    private $patternMatcherDate;
    private $patternMatcherPriority;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $patternDate = '/^\[([0-9]{4}-[[0-9]{2}-[[0-9]{2}).*/';
        $patternPriority = '/^\[[0-9]{4}-[[0-9]{2}-[[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}\]\s[a-z]*\.([a-zA-Z]*).*/';
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

    public function Provider()
    {
        return array(
            array('[2013-10-14 16:21:47] event.DEBUG: Notified event "kernel.controller" to listener "Symfony\Bundle\FrameworkBundle\DataCollector\RouterDataCollector::onKernelController". [] []'),
            array('[2013-10-14 16:21:47] event.DEBUG: Notified event "kernel.controller" to listener "Sensio\Bundle\FrameworkExtraBundle\EventListener\TemplateListener::onKernelController". [] []')
        );
    }

} 