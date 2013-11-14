<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Profiler\Engine\Decompiler;


interface DecompilerInterface
{

    /**
     *  Breaks a string into an array
     *
     * @param string $input  The input string
     *
     * @return Array
     */
    public function split($input);

}