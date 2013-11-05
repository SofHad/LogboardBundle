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


interface ProfilerManagerInterface
{

    /**
     * Load profiles
     *
     * @param QueryManagerInterface $queryManager  The query manager object
     *
     * @return void
     */
    public function loadProfiles(QueryManagerInterface $queryManager);

    /**
     * Get Quantitative data
     *
     * @return void
     */
    public function countData();

    /**
     * Get Collector
     *
     * @return \Symfony\Component\HttpKernel\DataCollector\LoggerDataCollector
     */
    public function getCollector();

    /**
     * Has Collector
     *
     * @return Boolean
     */
    public function hasCollector();

    /**
     * Get Collector
     *
     * @return \Symfony\Component\HttpKernel\Profiler\Profile
     */
    public function getProfile();

    /**
     * Get panel
     *
     * @return string
     */
    public function getPanel();

    /**
     * Get the data
     *
     * @return Array
     */
    public function getData();

    /**
     * Get profiler
     *
     * @return \Symfony\Component\HttpKernel\Profiler\Profiler
     */
    public function getProfiler();

    /**
     * Get counted data
     *
     * @return Profiler
     */
    public function getCountedData();
}
