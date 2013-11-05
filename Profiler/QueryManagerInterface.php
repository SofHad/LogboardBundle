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
 * PQueryManagerInterface
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
interface QueryManagerInterface
{

    /**
     * Handle the queries
     *
     * @param \Symfony\Component\HttpFoundation\Request   $request    The request
     * @param string                                      $token      The token
     *
     * @return void
     */

    public function handleQueries(Request $request, $token);

    /**
     * Check Engine
     *
     * @return void
     */
    public function checkEngine();

    /**
     * Selact the chart
     *
     * @return void
     */
    public function selectChart();

    /**
     * Get chart
     *
     * @return void
     */
    public function getChart();

    /**
     * Generate the icon switcher url
     *
     * @return void
     */
    public function generateIconSwitcherUrl();

    /**
     * Get the icon switcher url
     *
     * @return string
     */
    public function getIconSwitcherUrl();

    /**
     * Get token
     *
     * @return string
     */
    public function getToken();

    /**
     * Get engine
     *
     * @return string
     */
    public function getEngine();
}
