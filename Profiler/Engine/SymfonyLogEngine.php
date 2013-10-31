<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\BeautyLogBundle\Profiler\Engine;

use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Symfony logs handler
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class SymfonyLogEngine implements EngineInterface {

    protected $profile;
    protected $profiler;
    protected $accessor;
    protected $currentToken;
    protected $comparators;
    protected $profiles;
    protected $comparatorsCount;
    protected $panel;

    /**
     * Construct
     *
     * @param Profiler $profiler            The Profiler
     *
     * @return void
     */
    public function __construct( Profiler $profiler, $comparatorsCount) {
        $this->profiler = $profiler;
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->comparatorsCount = $comparatorsCount;
        $this->profiles = array();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function loadProfiles($profile=null, $panel){
        $this->profile = $profile;
        $this->panel = $panel;
        $this->loadComparators();
        $this->heapUp();

        return $this->profiles;
    }

    /**
     * Load the comparators
     *
     * @return void
     */
    public function loadComparators(){
        $this->comparators = $this->profiler->find($this->profile->getIp(), $this->profile->getUrl(), $this->comparatorsCount, $this->profile->getMethod(),  null, \date("Y-m-d H:i:s"));
    }

    /**
     * {@inheritdoc}
     *
     */
    public function heapUp(){
        foreach($this->comparators as $comparator){
            $token = $this->accessor->getValue($comparator, '[token]');
            $profile = $this->profiler->loadProfile($token);
            $this->profiles[$this->getName()][$comparator["time"]]['token'] = $token;
            $this->profiles[$this->getName()][$comparator["time"]]['profile'] = $profile ;
            $this->profiles[$this->getName()][$comparator["time"]]['data'] = $profile->getCollector($this->panel)->getLogs();
        }
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getName(){
        return  'symfony.log';
    }
}
