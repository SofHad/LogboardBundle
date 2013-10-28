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

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\WebProfilerBundle\Profiler\TemplateManager;
use So\BeautyLogBundle\Model\Meter;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccess;

use Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController as BaseProfilerController;

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
     * @param string  $token   The profiler token
     *
     * @return Response A Response instance
     *
     * @throws NotFoundHttpException
     */
    public function panelLogAction($token)
    {
        $this->templates = $this->container->getParameter('data_collector.templates');
        $this->profiler = $this->container->get("profiler");
        $this->twig = $this->container->get("twig");
        $request = $this->container->get('request');
        $this->accessor = PropertyAccess::createPropertyAccessor();

        //$profile = $this->profiler->loadProfile($token);

       // $similarData = $this->profiler->find($profile->getIp(), $profile->getUrl(), 3, $profile->getMethod(),  null, \date("Y-m-d H:i:s"));


        $engineService = null === $request->query->get("engine") ? $this->container->getParameter("beauty_log.engine_default"): "blz";
        $engine = $this->container->get($engineService);
        $profilerLoader = $this->container->get("beauty_log.profiler_loader");
        $profilerLoader->loadProfiles($engine, $token, "ChartPie");

        if (null === $this->profiler) {
            throw new NotFoundHttpException('The profiler must be enabled.');
        }

        $this->profiler->disable();

        $panel = $request->query->get('panel', 'request');
        $page = $request->query->get('page', 'home');
        $profile = $this->accessor->getValue($profilerLoader->getCurrentProfile(), '[profile]');

        if (!$profile) {
            return new Response($this->twig->render('WebProfilerBundle:Profiler:info.html.twig', array('about' => 'no_token', 'token' => $token)), 200, array('Content-Type' => 'text/html'));
        }

        if (!$profile->hasCollector($panel)) {
            throw new NotFoundHttpException(sprintf('Panel "%s" is not available for token "%s".', $panel, $token));
        }

        $getCollectorPanel = $profile->getCollector($panel);

        $meter = $this->container->get("beauty_log.counter");
        $countedData = $meter->handle($getCollectorPanel->getLogs())->getCountedData();

        return new Response(
            $this->twig->render("BeautyLogBundle:Collector:logger.html.twig",
                array(
                    'token'     => $token,
                    'profile'   => $profile,
                    'collector' => $profile->getCollector($panel),
                    'panel'     => $panel,
                    'page'      => $page,
                    'request'   => $request,
                    'templates' => $this->getTemplateManager()->getTemplates($profile),
                    'is_ajax'   => $request->isXmlHttpRequest(),
                    'countedData'   => $countedData,
                )
            ),
            200,
            array('Content-Type' => 'text/html')
        );
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
