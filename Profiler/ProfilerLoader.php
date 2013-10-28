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

use Symfony\Component\Config\Definition\IntegerNode;
use Symfony\Component\HttpKernel\Profiler\Profiler;

class ProfilerLoader {

	private $profiler;

	private $comparators;

	private $counter;

	private $currentToken;

	private $profiles = array();

	private $dataCounted;

	private $comparatorsProfiles;

	private $comparatorsCount;

	private $accessor;

    private $chart;

    private $currentProfile;


	public function __construct( Profiler $profiler , Counter $counter, $comparatorsCount) {

        $this->profiler = $profiler;
        $this->counter = $counter;
        $this->comparatorsCount = $comparatorsCount;
	}

    public function heapUp(){


        $this->profiles["current"]["token"] = $this->currentToken;

    }

    public function loadProfiles($currentToken, $chart){

        $this->currentToken = $currentToken;
        $this->chart = $chart;
        $this->currentProfile = $this->profiler->loadProfile($this->currentToken);
        $this->loadComparators();
        $this->heapUp();
    }

    public function loadComparators(){

       $this->comparators = $this->profiler->find($this->currentProfile->getIp(), $this->currentProfile->getUrl(), $this->comparatorsCount, $this->currentProfile->getMethod(),  null, \date("Y-m-d H:i:s"));
    }

    public function load(){

    }

    public function handle(){

    }

}
