<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\BeautyLogBundle\Profiler\Engine;
use So\BeautyLogBundle\Profiler\Engine\Finder\FinderInterface;
use So\BeautyLogBundle\Profiler\Parameter\ParametersHandlerInterface;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\PropertyAccess\PropertyAccess;


/**
 * Symfony logs handler
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class SymfonyLogEngine implements EngineInterface
{

    protected $profile;
    protected $profiler;
    protected $accessor;
    protected $data;
    protected $profiles;
    protected $dataCount;
    protected $panel;
    protected $finder;
    protected $parameters;
    protected $parametersHandler;

    /**
     * Construct
     *
     * @param Profiler                    $profiler              The Profiler
     * @param FinderInterface             $finder                The Finder
     * @param ParametersHandlerInterface  $parametersHandler     The Finder
     * @param integer                     $dataCount             The count of data
     * @param string                      $panel                 The panel
     *
     * @return void
     */
    public function __construct(Profiler $profiler, FinderInterface $finder, ParametersHandlerInterface $parametersHandler, $dataCount, $panel)
    {
        $this->profiler = $profiler;
        $this->finder = $finder;
        $this->parametersHandler = $parametersHandler;
        $this->dataCount = $dataCount;
        $this->panel = $panel;
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->profiles = array();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function loadProfiles(Profile $profile = null)
    {
        $this->profile = $profile;
        $this->parameters = $this->parametersHandler->getParameters($this->profile);

        $this->find();

        $this->heapUp();

        return $this->profiles;
    }

    /**
     * Find data
     *
     * @return void
     */
    public function find()
    {
        $this->data = $this->finder->find($this->parameters);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function heapUp()
    {
        $this->profiles = array();

        foreach ($this->data as $item) {
            $token = $this->accessor->getValue($item, '[token]');
            $profile = $this->profiler->loadProfile($token);

            $this->profiles = array_merge($profile->getCollector($this->panel)->getLogs(), $this->profiles);
        }
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getName()
    {
        return 'symfony.log';
    }
}
