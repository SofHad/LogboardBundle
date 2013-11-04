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

use Symfony\Component\HttpFoundation\Request;

/**
 * Profilers manager
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class QueryManager
{

    const DEFAULT_ENGINE = 'symfony_log_engine';

    protected $iconSwitcherUrl;
    protected $engine;
    protected $token;
    protected $request;
    protected $isEngineSubmitted = false;


    /**
     * Constructor
     *
     * @param string $panel                        The panel
     *
     * @return void
     */
    public function __construct($router, $panel)
    {
        $this->router = $router;
        $this->panel = $panel;
    }


    /**
     * Handle the queries
     *
     * @param \Symfony\Component\HttpFoundation\Request\Request   $request    The request
     * @param string                                              $token      The token
     *
     * @return void
     */
    public function handleQueries(Request $request, $token)
    {
        $this->request = $request;
        $this->token = $token;

        $this->checkEngine();

        $this->generateIconSwitcherUrl();
    }


    /**
     * Check Engine
     *
     * @return void
     */
    protected function checkEngine()
    {
        if($this->request->query->has('engine')){
            $this->isEngineSubmitted = true;
        }

        $this->engine = $this->request->query->get('engine', 'symfony_log_engine');
    }

    /**
     * Generate the icon switcher url
     *
     * @return void
     */
    public function generateIconSwitcherUrl()
    {
        $currentRoute = $this->request->attributes->get('_route');
        $this->iconSwitcherUrl = $this->router
                           ->generate($currentRoute, array('token' => $this->token ), true);

        $this->iconSwitcherUrl .= "?panel=".$this->panel;

        if($this->isEngineSubmitted){
            $this->iconSwitcherUrl .= "&engine=".$this->engine;
        }
    }

    /**
     * Get the icon switcher url
     *
     * @return string
     */
    public function getIconSwitcherUrl()
    {
       return $this->iconSwitcherUrl;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get engine
     *
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }
}
