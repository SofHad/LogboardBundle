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
use Symfony\Component\Routing\Router;

/**
 * Profilers manager
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class QueryManager implements QueryManagerInterface
{

    const DEFAULT_ENGINE = 'symfony_log_engine';

    protected $iconSwitcherUrl;
    protected $engine;
    protected $token;
    protected $request;
    protected $isEngineSubmitted = false;
    protected $defaultChart;
    protected $chart;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Routing\Router   $router                       The panel
     * @param string                              $panel                        The panel
     * @param string                              $defaultChart                 The default chart
     *
     * @return void
     */
    public function __construct(Router $router, $panel, $defaultChart)
    {
        $this->router = $router;
        $this->panel = $panel;
        $this->defaultChart = $defaultChart;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function handleQueries(Request $request, $token)
    {
        $this->request = $request;
        $this->token = $token;

        $this->checkEngine();

        $this->generateIconSwitcherUrl();

        $this->selectChart();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function checkEngine()
    {
        if($this->request->query->has('engine')){
            $this->isEngineSubmitted = true;
        }

        $this->engine = $this->request->query->get('engine', null);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function selectChart()
    {
        $this->chart = $this->request->query->get('chart', $this->defaultChart );
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getChart()
    {
        return $this->chart;
    }

    /**
     * {@inheritdoc}
     *
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
     * {@inheritdoc}
     *
     */
    public function getIconSwitcherUrl()
    {
       return $this->iconSwitcherUrl;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getEngine()
    {
        return $this->engine;
    }
}
