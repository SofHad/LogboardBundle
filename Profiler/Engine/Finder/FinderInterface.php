<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\BeautyLogBundle\Profiler\Engine\Finder;


interface FinderInterface
{

    /**
     * Find the data
     *
     * @param array $options
     *
     * @return Array
     */
    public function find(Array $options);

}