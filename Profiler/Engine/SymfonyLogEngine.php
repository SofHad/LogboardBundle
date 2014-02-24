<?php
/**
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Profiler\Engine;

use So\LogboardBundle\Profiler\DataResolver;

/**
 * Class SymfonyLogEngine
 *
 * @package So\LogboardBundle\Profiler\Engine
 * @author  Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class SymfonyLogEngine extends Engine
{
    /**
     * {@inheritdoc}
     *
     */
    public function heapUp()
    {
        $this->profiles = array();

        foreach ($this->data as $item) {
            $token   = $this->accessor->getValue($item, '[token]');
            $panel   = $this->accessor->getValue($this->parameters, '[panel]');
            $profile = $this->profiler->loadProfile($token);

            $collections = DataResolver::refine(
                $profile->getCollector($panel)->getLogs()
            );

            $this->profiles = array_merge($collections, $this->profiles);
        }

    }
}
