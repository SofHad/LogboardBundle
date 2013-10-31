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

interface ProfilerManagerInterface {

    /**
     * Load profiles
     *
     * @param Array $engines                      Array of engines
     * @param string $token                       The token
     *
     * @return void
     */
    public function loadProfiles(Array $engines, $token);

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
    public function getMainCollector();

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
    public function getMainProfile();

    /**
     * Profile data
     *
     * @return Array
     */
    public function mainProfileData();

    /**
     * Get panel
     *
     * @return string
     */
    public function getPanel();
}
