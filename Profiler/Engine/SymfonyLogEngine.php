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

    protected $mainProfile;
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
    public function __construct( Profiler $profiler) {
        $this->profiler = $profiler;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function loadProfiles($token, $comparatorsCount, $panel){

        $this->token = $token;
        $this->comparatorsCount = $comparatorsCount;
        $this->panel = $panel;
        $this->mainProfile = $this->profiler->loadProfile($this->token);
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
        $this->comparators = $this->profiler->find($this->mainProfile->getIp(), $this->mainProfile->getUrl(), $this->comparatorsCount, $this->mainProfile->getMethod(),  null, \date("Y-m-d H:i:s"));
    }

    /**
     * {@inheritdoc}
     *
     */
    public function heapUp(){
        $this->profiles["main"]["token"] = $this->token;
        $this->profiles["main"]["profile"] = $this->mainProfile;

        foreach($this->comparators as $comparator){
            $this->profiles[$comparator["time"]]['token'] = $this->accessor->getValue($comparator, '[token]');
            $this->profiles[$comparator["time"]]['profile'] = $this->profiler->loadProfile($this->accessor->getValue($comparator, '[token]'));
        }
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getProfiler(){
        return  $this->profiler;
    }
}
