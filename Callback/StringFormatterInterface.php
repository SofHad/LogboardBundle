<?php
/**
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Callback;

/**
 * Interface StringFormatterInterface
 *
 * @package So\LogboardBundle\Callback
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
Interface StringFormatterInterface {

    /**
     * Returns a string that has been converted to uppercase for $data['key]
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function uppercase(Array $data);

    /**
     * Capitalize the first letter for $data['key]
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function capitalize(Array $data);
}