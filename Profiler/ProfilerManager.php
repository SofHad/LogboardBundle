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
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Profilers manager
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
    protected $engines;
    protected $panel;
    protected $collector;
    protected $profiles = array();

    /**
     * Constructor
     *
     * @param CounterInterface $counter            The counter
     * @param Profiler $profiler                   The profiler
     * @param string $panel                        The panel
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
    public function loadProfiles(Array $engines, $token)
    {
        $this->engines = $engines;
        $this->token = $token;

        $this->executeLoading();
    }

    /**
     * Handle the loading operation
     *
     * @return void
     */
    public function executeLoading()
    {
        $this->getProfile();
        $this->initializeCountedData();

        foreach($this->engines as $engine){
            $this->profiles = $engine->loadProfiles($this->profile);
        }
    }

    /**
     * {@inheritdoc}
     *
     */
    public function initializeCountedData()
    {
        if(null ===  $this->collector){
            $this->getCollector();
        }

        $this->countedData['primary']['current'] = $this->counter->handle($this->collector->getLogs())->getCountedData();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function countData()
    {
        foreach($this->profiles as $k => $profile){
            $this->countedData[$profile['name']][]= $this->counter->handle($profile['data'])->getCountedData();
        }
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getCollector()
    {
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
    public function getProfiles()
    {
        return $this->profiles;
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
