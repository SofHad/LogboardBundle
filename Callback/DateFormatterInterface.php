<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Callback;

/**
 * Interface DateFormatterInterface
 *
 * @package So\LogboardBundle\Callback
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
Interface DateFormatterInterface {

    /**
     *
     * Returns a string formatted according to the format "D, j-M-Y"
     * Input example: [2013-11-07 22:07:39]
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function standardFormat(Array $data);

    /**
     * Returns a string formatted according to the format "D, j-M-Y"
     * Input example: [Wed Nov 06 09:55:19.556458 2013]
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function apacheFormat(Array $data);
}