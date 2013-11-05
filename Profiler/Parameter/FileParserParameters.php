<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\BeautyLogBundle\Profiler\Parameter;

use Symfony\Component\HttpKernel\Profiler\Profile;

/**
 * Symfony logs handler
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class FileParserParameters implements ParametersHandlerInterface
{

    /**
     * {@inheritdoc}
     *
     */
    public function getParameters(Profile $profile)
    {

    }
}
