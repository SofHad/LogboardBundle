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
use So\LogboardBundle\Tests\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Data Resolver Test
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class DataResolverTest extends WebTestCase
{

    public function testRefine()
    {

        $DataProvider = new DataProvider();
        $collections = $DataProvider->unrefinedProfilerData();

        $data = DataResolver::refine($collections);

        $this->assertArrayHasKey('key', $data[0]);
        $this->assertArrayHasKey('value', $data[0]);
        $this->assertEquals("DEBUG", $data[0]['key']);
        $this->assertCount(2, $data[0]);
        $this->assertCount(20, $data);
    }
}