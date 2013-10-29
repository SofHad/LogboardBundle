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
    protected $token;
    protected $countedData;
    protected $comparatorsCount;
    protected $accessor;
    protected $chart;
    protected $mainProfile;
    protected $engine;
    protected $panel;
    protected $mainCollector;
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
        $this->mainCollector = null;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function loadProfiles(EngineInterface $engine, $token, $panel, $chart)
    {
        $this->engine = $engine;
        $this->token = $token;
        $this->panel = $panel;
        $this->chart = $chart;
        $this->profiles = $this->engine->loadProfiles($token, $this->comparatorsCount, $this->panel);
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
        if(null ===  $this->mainCollector){
            $this->getMainCollector();
        }

        return $this->countedData = $this->counter->handle($this->mainCollector->getLogs())->getCountedData();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getMainCollector()
    {
        return $this->mainCollector = $this->mainProfile->getCollector($this->panel);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function hasCollector()
    {
        return $this->mainProfile->hasCollector($this->panel);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getMainProfile()
    {
        return $this->mainProfile = $this->accessor->getValue($this->mainProfileData(), '[profile]');
    }

    /**
     * {@inheritdoc}
     *
     */
    public function mainProfileData()
    {
        return $this->accessor->getValue($this->profiles, '[main]');
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
