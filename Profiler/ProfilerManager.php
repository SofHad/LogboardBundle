<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\BeautyLogBundle\Profiler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Profiler Manager
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class ProfilerManager implements ProfilerManagerInterface
{

    protected $profiler;
    protected $counter;
    protected $token;
    protected $countedData;
    protected $accessor;
    protected $profile;
    protected $engine;
    protected $panel;
    protected $collector;
    protected $queryManager;
    protected $data = array();

    /**
     * Constructor
     *
     * @param CounterInterface                                          $counter    The counter
     * @param \Symfony\Component\HttpKernel\Profiler\Profiler\Profiler  $profiler   The profiler
     * @param string                                                    $panel      The panel
     *
     * @return void
     */
    public function __construct(CounterInterface $counter, Profiler $profiler, $panel)
    {
        $this->counter = $counter;
        $this->profiler = $profiler;
        $this->panel = $panel;
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->collector = null;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function loadProfiles(QueryManagerInterface $queryManager)
    {
        $this->queryManager = $queryManager;
        $this->token = $queryManager->getToken();
        $this->engine = $queryManager->getEngine();

        $this->getProfile();

        $this->countData();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function countData()
    {
        if (null === $this->engine) {
            $this->countedData = $this->counter->handle($this->getCollector()->getLogs())
                                               ->getCountedData();
        }else{
            $this->data = $this->engine->loadProfiles($this->profile);
            $this->countedData = $this->counter->handle($this->data)->getCountedData();
        }
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getCollector()
    {
        if (null !== $this->collector) {
            $this->collector;
        }

        return $this->collector = $this->profile->getCollector($this->panel);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function hasCollector()
    {
        return $this->profile->hasCollector($this->panel);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getProfile()
    {
        return $this->profile = $this->profiler->loadProfile($this->token);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getPanel()
    {
        return $this->panel;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getProfiler()
    {
        return $this->profiler;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getCountedData()
    {
        return $this->countedData;
    }

}
