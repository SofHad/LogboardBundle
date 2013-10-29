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
class ProfilerLoader
{

    protected $profiler;
    protected $counter;
    protected $currentToken;
    protected $countedData;
    protected $comparatorsCount;
    protected $accessor;
    protected $chart;
    protected $currentProfile;
    protected $engine;
    protected $panel;
    protected $collector;
    protected $profiles = array();

    /**
     * Construct
     *
     * @param Counter $counter            The profiler counter
     * @param integer $comparatorsCount   The number of comparators
     *
     * @return void
     */
    public function __construct(CounterInterface $counter, $comparatorsCount)
    {
        $this->counter = $counter;
        $this->comparatorsCount = $comparatorsCount;
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->collector = null;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function loadProfiles(EngineInterface $engine, $currentToken, $panel, $chart)
    {
        $this->engine = $engine;
        $this->currentToken = $currentToken;
        $this->panel = $panel;
        $this->chart = $chart;
        $this->profiles = $this->engine->loadProfiles($currentToken, $this->comparatorsCount);
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
        return $this->profiler = $this->engine->getProfiler();
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
        return $this->collector = $this->currentProfile->getCollector($this->panel);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function hasCollector()
    {
        return $this->currentProfile->hasCollector($this->panel);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getCurrentProfile()
    {
        return $this->currentProfile = $this->accessor->getValue($this->currentProfileData(), '[profile]');
    }

    /**
     * {@inheritdoc}
     *
     */
    public function currentProfileData()
    {
        return $this->accessor->getValue($this->profiles, '[current]');
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getPanel()
    {
        return $this->panel;
    }
}
