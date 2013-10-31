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

use Symfony\Component\HttpKernel\Profiler\Profile;
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
     * @param integer $comparatorsCount     The count of comparators
     * @param integer $panel                The panel
     *
     * @return void
     */
    public function __construct( Profiler $profiler, $comparatorsCount, $panel) {
        $this->profiler = $profiler;
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->comparatorsCount = $comparatorsCount;
        $this->panel = $panel;
        $this->profiles = array();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function loadProfiles(Profile $profile=null){

        
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
            $token = $this->accessor->getValue($comparator, '[token]');
            $profile = $this->profiler->loadProfile($token);
            $this->profiles[$comparator["time"]]['token'] = $token;
            $this->profiles[$comparator["time"]]['profile'] = $profile ;
            $this->profiles[$comparator["time"]]['data'] = $profile->getCollector($this->panel)->getLogs();
            $this->profiles[$comparator["time"]]['name'] = $this->getName();
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
