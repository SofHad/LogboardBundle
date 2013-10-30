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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class ProfilerController extends ContainerAware
{
    private $profiler;
    private $twig;
    private $templateManager = null;
    private $templates;
    private $accessor;
    private $request;
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
    public function panelLogAction($token)
    {

        $this->loadServices();

        $sfLogEngine = $this->container->get("beauty_log.symfony_log_engine");
        $chart = $this->container->getParameter('beauty_log.chart_pie');
        $panel = $this->request->query->get('panel', 'request');

        $this->profilerManager->loadProfiles(array($sfLogEngine), $token, $panel, $chart);

        $this->profiler = $this->profilerManager->getProfiler();
        if (null === $this->profiler) {
            throw new NotFoundHttpException('The profiler must be enabled.');
        }

        $this->profiler->disable();

        $page = $this->request->query->get('page', 'home');

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
                    'page' => $page,
                    'request' => $this->request,
                    'templates' => $this->getTemplateManager()->getTemplates($profile),
                    'is_ajax' => $this->request->isXmlHttpRequest(),
                    'counted_data' => $this->profilerManager->getCountedData(),
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
        $this->request = $this->container->get('request');
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
