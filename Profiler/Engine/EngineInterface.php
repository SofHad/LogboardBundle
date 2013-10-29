<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\BeautyLogBundle\Profiler\Engine;

interface EngineInterface {

    /**
     * Load profiles
     *
     * @param string $currentToken                The token
     * @param integer $comparatorsCount           The number of comparators
     * @param string $panel                       The panel
     *
     * @return Array
     */
    public function loadProfiles($currentToken, $comparatorsCount, $panel);

    /**
     * Heap up the mixed data
     *
     * @return void
     */
    public function heapUp();

    /**
     * Get profiler
     *
     * @return Profiler
     */
    public function getProfiler();
}
