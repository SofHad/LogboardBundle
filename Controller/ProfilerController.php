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
     * Renders a profiler for a logger.
     *
     * @param string  $token The profiler token
     * @param Request $request The Request
     *
     * @return Response A Response instance
     *
     * @throws NotFoundHttpException
     */
    public function panelLogAction($token, Request $request)
    {
        $this->loadServices();

        $this->queryManager->handleQueries($request, $token);

        $engine = $this->queryManager->getEngineServiceId();

        if (null !== $engine) {
            $this->queryManager->setEngine($this->container->get('logboard.' . $engine));
        }

        $this->profilerManager->loadProfiles($this->queryManager);

        if($this->queryManager->isPreview()){
            return new Response($this->twig->render("LogboardBundle:Collector:test.html.twig", array('logs_stack' => $this->profilerManager->getPreviewData(), 'preview' => $this->queryManager->getPreview() )), 200, array('Content-Type' => 'text/html'));
        }

        $this->profiler = $this->profilerManager->getProfiler();
        if (null === $this->profiler) {
            throw new NotFoundHttpException('The profiler must be enabled.');
        }

        $profile = $this->profilerManager->getProfile();
        if (!$profile) {
            return new Response($this->twig->render('WebProfilerBundle:Profiler:info.html.twig', array('about' => 'no_token', 'token' => $token)), 200, array('Content-Type' => 'text/html'));
        }

        if (!$this->profilerManager->hasCollector()) {
            throw new NotFoundHttpException(sprintf('Panel "%s" is not available for token "%s".', $this->profilerManager->getPanel(), $token));
        }

        return new Response(
            $this->twig->render("LogboardBundle:Collector:logger.html.twig",
                array(
                    'token' => $token,
                    'profile' => $profile,
                    'collector' => $this->profilerManager->getCollector(),
                    'panel' => $this->profilerManager->getPanel(),
                    'request' => $request,
                    'templates' => $this->getTemplateManager()->getTemplates($profile),
                    'is_ajax' => $request->isXmlHttpRequest(),
                    'counted_data' => $this->profilerManager->getCountedData(),
                    'query_manager' => $this->queryManager,
                    'logs_stack' => $this->profilerManager->getData()
                )
            ),
            200,
            array('Content-Type' => 'text/html')
        );
    }

    /**
     * Initialize variables
     *
     * @return void
     */
    public function loadServices()
    {
        $this->templates = $this->container->getParameter('data_collector.templates');
        $this->twig = $this->container->get("twig");
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->profilerManager = $this->container->get("logboard.profiler_manager");
        $this->queryManager = $this->container->get('logboard.query_manager');
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
