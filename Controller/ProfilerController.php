<?php

/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Controller;

use So\LogboardBundle\Exception\BadQueryHttpException;
use So\LogboardBundle\Exception\NotFoundHttpException;
use Symfony\Bundle\WebProfilerBundle\Profiler\TemplateManager;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Logboard controller
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class ProfilerController extends ContainerAware
{
    /**
     * The Profiler
     * @var \Symfony\Component\HttpKernel\Profiler\Profiler
     */
    private $profiler;
    /**
     * Twig
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * The template manager
     * @var \Symfony\Bundle\WebProfilerBundle\Profiler\TemplateManager
     */
    private $templateManager = null;
    /**
     * Templates
     * @var Array
     */
    private $templates;
    /**
     * Property accessor component
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $accessor;
    /**
     * The profiler manager
     * @var \So\LogboardBundle\Profiler\ProfilerManagerInterface
     */
    private $profilerManager;
    /**
     * Query manager
     * @var \So\LogboardBundle\Profiler\QueryManagerInterface
     */
    private $queryManager;
    /**
     * Engine
     * @var string
     */
    private $engine;

    /**
     * The Logboard controller
     *
     * @param string $token The profiler token
     * @param Request $request The Request
     *
     * @return Response A Response instance
     *
     * @throws NotFoundHttpException if the profiler is null or the service does not exist
     */
    public function logboardAction($token, Request $request)
    {
        $this->loadServices($token, $request);
        if ($this->queryManager->isPreview())
            return new Response($this->twig->render("LogboardBundle:Collector:viewer.html.twig", array('logs_stack' => $this->profilerManager->getPreviewData(), 'preview' => $this->queryManager->getPreview())), 200, array('Content-Type' => 'text/html'));

        if (null === $this->profiler = $this->profilerManager->getProfiler())
            throw new NotFoundHttpException('The profiler must be enabled.');

        if (!$profile = $this->profilerManager->getProfile())
            return new Response($this->twig->render('WebProfilerBundle:Profiler:info.html.twig', array('about' => 'no_token', 'token' => $token)), 200, array('Content-Type' => 'text/html'));

        return new Response( $this->twig->render("LogboardBundle:Collector:logger.html.twig", array(
                'profile' => $profile,
                'profiler_manager' => $this->profilerManager,
                'templates' => $this->getTemplateManager()->getTemplates($profile),
                'is_ajax' => $request->isXmlHttpRequest(),
                'query_manager' => $this->queryManager)
        ), 200, array('Content-Type' => 'text/html'));
    }

    /**
     * Initialize variables
     *
     * @return void
     */
    protected function loadServices($token, Request $request)
    {
        $this->templates = $this->container->getParameter('data_collector.templates');
        $this->twig = $this->container->get("twig");
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->profilerManager = $this->container->get("logboard.profiler_manager");
        $this->queryManager = $this->container->get('logboard.query_manager');

        $this->queryManager->handleQueries($request, $token);

        $this->engine = $this->queryManager->getEngineServiceId();

        $this->setEngine();

        $this->profilerManager->loadProfiles($this->queryManager);
    }

    /**
     * Set the engine for queryManager
     *
     * @throws BadQueryHttpException if The specified engine does not exist
     */
    protected function setEngine()
    {
        if (null !== $this->engine) {
            $service = sprintf('logboard.%s', $this->engine);
            if ($this->container->has($service)) {
                $this->queryManager->setEngine($this->container->get($service));
            } else {
                throw new BadQueryHttpException(sprintf('The specified Logboard engine "%s" does not exist or is not configured correctly', $service));
            }
        }
    }

    /**
     * Gets the Template Manager.
     *
     * @return TemplateManager The Template Manager
     */
    protected function getTemplateManager()
    {
        if (null === $this->templateManager) {
            $this->templateManager = new TemplateManager($this->profiler, $this->twig, $this->templates);
        }

        return $this->templateManager;
    }

}
