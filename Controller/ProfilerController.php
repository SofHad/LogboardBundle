<?php

/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\BeautyLogBundle\Controller;

use Symfony\Bundle\WebProfilerBundle\Profiler\TemplateManager;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ProfilerController extends ContainerAware
{
    private $profiler;
    private $twig;
    private $templateManager = null;
    private $templates;
    private $accessor;
    private $profilerManager;

    /**
     * Renders a profiler for a logger.
     *
     * @param string $token   The profiler token
     *
     * @return Response A Response instance
     *
     * @throws NotFoundHttpException
     */
    public function panelLogAction($token, Request $request)
    {

        $this->loadServices();

        $queryManager = $this->container->get('beauty_log.query_manager');
        $queryManager->handleQueries($request, $token);

        $this->profilerManager->loadProfiles($queryManager);

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
            $this->twig->render("BeautyLogBundle:Collector:logger.html.twig",
                array(
                    'token' => $token,
                    'profile' => $profile,
                    'collector' => $this->profilerManager->getCollector(),
                    'panel' => $this->profilerManager->getPanel(),
                    'request' => $request,
                    'templates' => $this->getTemplateManager()->getTemplates($profile),
                    'is_ajax' => $request->isXmlHttpRequest(),
                    'counted_data' => $this->profilerManager->getCountedData(),
                    'query_manager' => $queryManager,
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
        $this->profilerManager = $this->container->get("beauty_log.profiler_manager");
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
