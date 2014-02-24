<?php
/**
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Profiler\Engine\Finder;

use Symfony\Component\HttpKernel\Profiler\Profiler;

/**
 * Class ProfilerFinder
 *
 * @package So\LogboardBundle\Profiler\Engine\Finder
 * @author  Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class ProfilerFinder implements FinderInterface
{
    /**
     * The data
     * @var Array
     */
    protected $data = array();

    /**
     * @param Profiler $profiler
     */
    public function __construct(Profiler $profiler)
    {
        $this->profiler = $profiler;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function find(Array $parameters)
    {
        return
            $this->data = $this->profiler
                ->find(
                    $parameters['ip'],
                    $parameters['url'],
                    $parameters['data_count'],
                    $parameters['method'],
                    $parameters['start'],
                    $parameters['end']
                );
    }

}
