<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Profiler;

use So\LogboardBundle\Profiler\Engine\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

/**
 * Profilers manager
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class QueryManager implements QueryManagerInterface
{

    /**
     * Icons chart urls
     * @var string
     */
    protected $iconSwitcherUrl;
    /**
     * The token
     * @var string
     */
    protected $token;
    /**
     * The request
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;
    /**
     * The default chart
     * @var string
     */
    protected $defaultChart;
    /**
     * The chart
     * @var string
     */
    protected $chart;
    /**
     * Preview value
     * @var Boolean
     */
    protected $preview;
    /**
     * The engine links urls
     * @var string
     */
    protected $engineSwitcherUrl;
    /**
     * Engine
     * @var \So\LogboardBundle\Profiler\Engine\EngineInterface
     */
    protected $engine = null;
    /**
     * The engine service id
     * @var string
     */
    protected $engineServiceId = null;
    /**
     * The engine submission status
     * @var Boolean
     */
    protected $isEngineSubmitted = false;
    /**
     * The chart submission status
     * @var Boolean
     */
    protected $isChartSubmitted = false;
    /**
     * Isser preview
     * @var Boolean
     */
    protected $isPreview = false;
    /**
     * The index variables (Titles, labels, services names)
     * @var Array
     */
    protected $index;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Routing\Router $router                       The panel
     * @param string $panel                        The panel
     * @param string $defaultChart                 The default chart
     *
     * @return void
     */
    public function __construct(Router $router, $panel, $defaultChart, $index)
    {
        $this->router = $router;
        $this->panel = $panel;
        $this->defaultChart = $defaultChart;
        $this->index = $index;
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

        $this->checkPreview();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function checkEngine()
    {
        if ($this->request->query->has('engine')) {
            $this->isEngineSubmitted = true;
        }

        $this->engineServiceId = $this->request->query->get('engine', null);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function selectChart()
    {
        $chart = $this->request->query->get('chart');

        if (null !== $chart) {
            $this->isChartSubmitted = true;
            $this->chart = $chart;
        } else {
            $this->chart = $this->defaultChart;
        }
    }

    /**
     * {@inheritdoc}
     *
     */
    public function generateSwitcherUrls()
    {
        $currentRoute = $this->request->attributes->get('_route');
        $this->router
            ->generate($currentRoute, array('token' => $this->token), true);

        $this->iconSwitcherUrl = $this->engineSwitcherUrl .= "?panel=" . $this->panel;

        if ($this->isEngineSubmitted) {
            $this->iconSwitcherUrl .= "&engine=" . $this->engineServiceId;
        }

        if ($this->isChartSubmitted) {
            $this->engineSwitcherUrl .= "&chart=" . $this->chart;
        }
    }

    /**
     * {@inheritdoc}
     *
     */
    public function checkPreview()
    {
        $this->preview = $this->request->query->get('preview');
        $this->isPreview = null !== $this->preview ? true : false;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function isPreview()
    {
        return $this->isPreview;
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
    public function getChart()
    {
        return $this->chart;
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
    public function isViewer()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getIndex()
    {
        return $this->index;
    }

}
