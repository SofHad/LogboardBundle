<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Profiler;

/**
 * Data Resolver
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class DataResolver
{

    /**
     * Data adapter
     *
     * @param Array   $collections   Data collection
     *
     * @return Array
     */
    public static function refine($collections)
    {
        $output = array();

        foreach ($collections as $k => $collection) {
            $output[$k]["key"] = $collection['priorityName'];
            $output[$k]["value"] = $collection['message'];
        }

        return $output;
    }
}
