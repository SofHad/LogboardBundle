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
use Symfony\Component\PropertyAccess\PropertyAccess;

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

    private $engine;


	public function __construct( Counter $counter, $comparatorsCount) {
    $this->counter = $counter;
    $this->comparatorsCount = $comparatorsCount;
    $this->accessor = PropertyAccess::createPropertyAccessor();
}

    public function loadProfiles($engine, $currentToken, $chart){

        $this->currentToken = $currentToken;
        $this->chart = $chart;
        $this->engine = $engine;
        $this->profiles = $this->engine->loadProfiles($currentToken, $this->comparatorsCount);
    }

    public function getProfiles(){
        return $this->profiles;
    }

    public function getCurrentProfile(){
        return $this->accessor->getValue($this->profiles, '[current]'); $this->profiles;
    }

}
