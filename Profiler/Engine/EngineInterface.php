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
     * @param Profile $profile   The Profile
     *
     * @return Array
     */
    public function loadProfiles($profile=null);

    /**
     * Heap up the mixed data
     *
     * @return void
     */
    public function heapUp();

}
