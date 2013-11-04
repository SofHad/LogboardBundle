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

use Symfony\Component\HttpKernel\Profiler\Profiler;

/**
 * Profiler Finder
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class ProfilerFinder implements FinderInterface
{

    protected $data = array();

    /**
     * Construct
     *
     * @param Profiler $profiler   The Profiler
     *
     * @return void
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
        return $this->data = $this->profiler->find($parameters['ip'], $parameters['url'], $parameters['dataCount'], $parameters['method'], $parameters['start'], $parameters['end']);
    }

}