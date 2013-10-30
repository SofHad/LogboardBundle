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
    public function loadProfiles($profile=null){
        $this->profile = $profile;
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
            $this->profiles[$this->getName()][$comparator["time"]]['token'] = $this->accessor->getValue($comparator, '[token]');
            $this->profiles[$this->getName()][$comparator["time"]]['profile'] = $this->profiler->loadProfile($this->accessor->getValue($comparator, '[token]'));
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
