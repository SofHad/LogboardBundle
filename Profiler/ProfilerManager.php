<?php
/**
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Profiler;

use So\LogboardBundle\Exception\BadQueryHttpException;
use So\LogboardBundle\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class ProfilerManager
 *
 * @package So\LogboardBundle\Profiler
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class ProfilerManager implements ProfilerManagerInterface
{
    /**
     * The Profiler
     * @var \Symfony\Component\HttpKernel\Profiler\Profiler
     */
    protected $profiler;

    /**
     * The counter
     * @var \So\LogboardBundle\Profiler\CounterInterface
     */
    protected $counter;

    /**
     * The token
     * @var string
     */
    protected $token;

    /**
     * Data counted
     * @var Array
     */
    protected $countedData;

    /**
     * Property accessor component
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $accessor;

    /**
     * The profile
     * @var \Symfony\Component\HttpKernel\Profiler\Profile
     */
    protected $profile;

    /**
     * The engine
     * @var \So\LogboardBundle\Profiler\Engine\EngineInterface
     */
    protected $engine;

    /**
     * The panel
     * @var string
     */
    protected $panel;

    /**
     * The collector
     * @var \Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface
     */
    protected $collector;

    /**
     * Query manager
     * @var \So\LogboardBundle\Profiler\QueryManagerInterface
     */
    protected $queryManager;

    /**
     * The data
     * @var Array
     */
    protected $data = array();

    /**
     * The preview data
     * @var Array
     */
    protected $previewData = array();

    /**
     * Constructor
     *
     * @param CounterInterface $counter The counter
     * @param \Symfony\Component\HttpKernel\Profiler\Profiler $profiler The profiler
     * @param string $panel The panel
     *
     * @return void
     */
    public function __construct(CounterInterface $counter, Profiler $profiler, $panel)
    {
        $this->counter = $counter;
        $this->profiler = $profiler;
        $this->panel = $panel;
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->collector = null;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function loadProfiles(QueryManagerInterface $queryManager)
    {
        $this->queryManager = $queryManager;
        $this->token = $this->queryManager->getToken();
        $this->engine = $this->queryManager->getEngine();

        $this->getProfile();

        if (null === $this->profile) {
            return;
        }

        $this->compile();

        if (null === $this->data) {
            throw new BadQueryHttpException(
                'The request was invalid or cannot be otherwise served
                 because the data cannot be null.'
            );
        }

        return $this->queryManager->isPreview() ? $this->aggregateData() : $this->countData();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getProfile()
    {
        $this->profile = $this->profiler->loadProfile($this->token);

        if(!$this->hasCollector()){
            throw new NotFoundHttpException(
                sprintf(
                'Panel "%s" is not available for token "%s".',
                    $this->getPanel(), $this->queryManager->getToken()
                )
            );
        }

        return $this->profile;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function compile()
    {
        $this->data = null === $this->engine
            ? DataResolver::refine($this->getCollector()->getLogs())
            : $this->engine->loadProfiles();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getCollector()
    {
        if (null !== $this->collector) {
            $this->collector;
        }

         return $this->collector = $this->profile->getCollector($this->panel);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getPanel()
    {
        return $this->panel;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function aggregateData()
    {
        $preview = $this->queryManager->getPreview();

        if (null === $preview) {
            throw new BadQueryHttpException(
                'The request was invalid or cannot be otherwise served
                because the preview value cannot be null.'
            );
        }

        foreach ($this->data as $item) {
            if ($preview === $item["key"]) {
                if (isset($this->previewData[$item["value"]])) {
                    $this->previewData[$item["value"]]['count']++;
                } else {
                    $this->previewData[$item["value"]]['count'] = 1;
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     *
     */
    public function countData()
    {
        if (empty($this->data)) {
            return;
        }

        $this->countedData = $this->counter->handle($this->data)
                                           ->getCountedData();
    }

    /**
     * {@inheritdoc}
     *
     */
    public function hasCollector()
    {
        return $this->profile->hasCollector($this->panel);
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getPreviewData()
    {
        return $this->previewData;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getProfiler()
    {
        return $this->profiler;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getCountedData()
    {
        return $this->countedData;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function setToken($token)
    {
        return $this->token = $token;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function setEngine($engine)
    {
        return $this->engine = $engine;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function setQueryManager($queryManager)
    {
        return $this->queryManager = $queryManager;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function setData($data)
    {
        return $this->data = $data;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function setProfile($profile)
    {
        return $this->profile = $profile;

    }

    /**
     * {@inheritdoc}
     *
     */
    public function setCollector($collector)
    {
        return $this->collector = $collector;

    }
}