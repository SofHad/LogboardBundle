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

        $this->initialize();
        $request = $this->container->get('request');
        $engineService = null === $request->query->get("engine") ? $this->container->getParameter("beauty_log.engine_default") : $request->query->get("engine");
        $engine = $this->container->get($engineService);

        $profilerLoader = $this->container->get("beauty_log.profiler_loader");
        $profilerLoader->loadProfiles($engine, $token, $request->query->get('panel', 'request'), "ChartPie");

        $this->profiler = $profilerLoader->getProfiler();
        if (null === $this->profiler) {
            throw new NotFoundHttpException('The profiler must be enabled.');
        }

        $this->profiler->disable();

        $page = $request->query->get('page', 'home');

        $profile = $profilerLoader->getCurrentProfile();
        if (!$profile) {
            return new Response($this->twig->render('WebProfilerBundle:Profiler:info.html.twig', array('about' => 'no_token', 'token' => $token)), 200, array('Content-Type' => 'text/html'));
        }

        if (!$profilerLoader->hasCollector()) {
            throw new NotFoundHttpException(sprintf('Panel "%s" is not available for token "%s".', $profilerLoader->getPanel(), $token));
        }

        return new Response(
            $this->twig->render("BeautyLogBundle:Collector:logger.html.twig",
                array(
                    'token' => $token,
                    'profile' => $profile,
                    'collector' => $profilerLoader->getCollector(),
                    'panel' => $profilerLoader->getPanel(),
                    'page' => $page,
                    'request' => $request,
                    'templates' => $this->getTemplateManager()->getTemplates($profile),
                    'is_ajax' => $request->isXmlHttpRequest(),
                    'countedData' => $profilerLoader->getCountedData(),
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
    public function initialize()
    {
        $this->templates = $this->container->getParameter('data_collector.templates');
        $this->twig = $this->container->get("twig");
        $this->accessor = PropertyAccess::createPropertyAccessor();
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
