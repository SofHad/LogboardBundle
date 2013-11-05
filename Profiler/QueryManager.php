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
    protected $token;
    protected $request;
    protected $defaultChart;
    protected $chart;
    protected $engineSwitcherUrl;
    protected $engine = null;
    protected $engineServiceId = null;
    protected $isEngineSubmitted = false;
    protected $isChartSubmitted = false;

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

        $this->selectChart();

        $this->generateSwitcherUrls();
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

        $this->engineServiceId = $this->request->query->get('engine', null);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function setEngine(EngineInterface $engine)
    {
        $this->engine = $engine;
    }


    /**
     * {@inheritdoc}
     *
     */
    public function getEngineServiceId()
    {
        return $this->engineServiceId;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function hasEngine()
    {
        return null === $this->engine ? false : true;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function selectChart()
    {
        $chart = $this->request->query->get('chart');

        if(null !== $chart){
            $this->isChartSubmitted = true;
            $this->chart = $chart;
        }else{
            $this->chart = $this->defaultChart ;
        }
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
    public function generateSwitcherUrls()
    {
        $currentRoute = $this->request->attributes->get('_route');
        $baseUrl = $this->router
                        ->generate($currentRoute, array('token' => $this->token ), true);

        $this->iconSwitcherUrl = $this->engineSwitcherUrl = $baseUrl .= "?panel=".$this->panel;

        if($this->isEngineSubmitted){
            $this->iconSwitcherUrl .= "&engine=".$this->engineServiceId;
        }

        if($this->isChartSubmitted){
            $this->engineSwitcherUrl .= "&chart=".$this->chart;
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
    public function getEngineSwitcherUrl()
    {
        return $this->engineSwitcherUrl;
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
