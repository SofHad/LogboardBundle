<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\BeautyLogBundle\Profiler;

use Symfony\Component\Translation\Tests\String;

interface ProfilerLoaderInterface {

	public function heapUp();

	public function loadProfiles($currentToken, $chart);

	public function handle();
}
