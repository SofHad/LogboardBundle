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
use So\BeautyLogBundle\Profiler\Engine\EngineInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;


/**
 * Profilers manager
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class ProfilerManager
{

    protected $profiler;
    protected $counter;
    protected $token;
    protected $countedData;
    protected $accessor;
    protected $chart;
    protected $profile;
    protected $engines;
    protected $panel;
    protected $collector;
    protected $profiles = array();

    /**
     * Construct
     *
     * @param Counter $counter            The profiler counter
     * @param integer $profiler           The profiler
     *
     * @return void
     */
    public function __construct(CounterInterface $counter, $profiler)
    {
        $this->counter = $counter;
        $this->profiler = $profiler;
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->collector = null;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function loadProfiles(Array $engines, $token, $panel, $chart)
    {
        $this->engines = $engines;
        $this->token = $token;
        $this->panel = $panel;
        $this->chart = $chart;

        $this->executeLoading();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function executeLoading()
    {
        $this->getProfile();

        foreach($this->engines as $engine){
            $this->profiles = $engine->loadProfiles($this->profile, $this->panel);
        }
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getCountedData()
    {
        if(null ===  $this->collector){
            $this->getCollector();
        }

        return $this->countedData = $this->counter->handle($this->collector->getLogs())->getCountedData();
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
    public function getChart()
    {
        return $this->chart;
    }
}
