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

interface ProfilerLoaderInterface {

    /**
     * Load profiles
     *
     * @param SymfonyLogEngine $engine            The engine
     * @param string $currentToken                The token
     * @param string $panel                       The panel
     * @param string $chart                       The Google chart type
     *
     * @return void
     */
    public function loadProfiles(SymfonyLogEngine $engine, $currentToken, $panel, $chart);

    /**
     * GET profiles
     *
     * @return Array
     */
    public function getProfiles();

    /**
     * GET profiler
     *
     * @return Profiler
     */
    public function getProfiler();

    /**
     * Get Quantitative data
     *
     * @return Array
     */
    public function getCountedData();

    /**
     * Get Collector
     *
     * @return LoggerDataCollector
     */
    public function getCollector();

    /**
     * Has Collector
     *
     * @return Boolean
     */
    public function hasCollector();

    /**
     * Collector hasser
     *
     * @return Boolean
     */
    public function getCurrentProfile();

    /**
     * Profile data
     *
     * @return Array
     */
    public function currentProfileData();

    /**
     * Get panel
     *
     * @return string
     */
    public function getPanel();
}
