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

interface CounterInterface
{

    /**
     * Handle the operation
     *
     * @param Array $collector     Data collection
     *
     * @return CounterInterface
     */
    public function handle(Array $collector);

    /**
     * Get Quantitative data
     *
     * @return Array
     */
    public function getCountedData();

    /**
     * Heap up the mixed data
     *
     * @return CounterInterface
     */
    public function heapUp();
}
