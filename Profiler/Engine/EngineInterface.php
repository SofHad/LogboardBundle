<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Profiler\Engine;

interface EngineInterface
{

    /**
     * Load profiles
     *
     * @return Array
     */
    public function loadProfiles();

    /**
     * Heap up the data
     *
     * @return void
     */
    public function heapUp();

}
