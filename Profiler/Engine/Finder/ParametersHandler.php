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

use Symfony\Component\HttpKernel\Profiler\Profile;

/**
 * Symfony logs handler
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class ParametersHandler implements ParametersHandlerInterface
{

    const DATA_COUNT = 20;

    /**
     * {@inheritdoc}
     *
     */
    public function getParameters(Profile $profile)
    {
        return array(
            'ip' => null,
            'url' => null,
            'dataCount' => self::DATA_COUNT,
            'method' => null,
            'start' => null,
            'end' => null,
        );
    }
}
