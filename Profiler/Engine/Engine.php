<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Profiler\Engine;
use So\LogboardBundle\Profiler\Engine\Finder\FinderInterface;
use So\LogboardBundle\Profiler\Parameter\ParametersHandlerInterface;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\PropertyAccess\PropertyAccess;


/**
 * Symfony logs handler
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
abstract class Engine implements EngineInterface
{
    /**
     * The profile
     * @var \Symfony\Component\HttpKernel\Profiler\Profile
     */
    protected $profile;

    /**
     * The Profiler
     * @var \Symfony\Component\HttpKernel\Profiler\Profiler
     */
    protected $profiler;

    /**
     * Property accessor component
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $accessor;

    /**
     * The data
     * @var Array
     */
    protected $data;

    /**
     * The profiles
     * @var Array
     */
    protected $profiles;

    /**
     * The data count
     * @var Array
     */
    protected $dataCount;

    /**
     * The panel
     * @var string
     */
    protected $panel;

    /**
     * The finder
     * @var \So\LogboardBundle\Profiler\Engine\Finder\FinderInterface
     */
    protected $finder;

    /**
     * The parameters
     * @var Array
     */
    protected $parameters;

    /**
     * The parameters handler
     * @var \So\LogboardBundle\Profiler\Parameter\ParametersHandlerInterface
     */
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
    public function __construct(Profiler $profiler, FinderInterface $finder, ParametersHandlerInterface $parametersHandler)
    {
        $this->profiler = $profiler;
        $this->finder = $finder;
        $this->parametersHandler = $parametersHandler;
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->profiles = array();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function loadProfiles(Profile $profile = null)
    {

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
    abstract public function heapUp();

    /**
     * {@inheritdoc}
     *
     */
    abstract public function getName();
}
