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

class ProfilerController extends ContainerAware
{
    private $profiler;
    private $twig;

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
        $this->profiler = $this->container->get("profiler");
        $this->twig = $this->container->get("twig");
        $profile = $this->profiler->loadProfile($token);
        if (null === $this->profiler) {
            throw new NotFoundHttpException('The profiler must be enabled.');
        }

        $this->profiler->disable();

        $request = $this->container->get('request');
        $panel = $request->query->get('panel', 'request');
        $page = $request->query->get('page', 'home');

        if (!$profile = $this->profiler->loadProfile($token)) {
            return new Response($this->twig->render('WebProfilerBundle:Profiler:info.html.twig', array('about' => 'no_token', 'token' => $token)), 200, array('Content-Type' => 'text/html'));
        }

        if (!$profile->hasCollector($panel)) {
            throw new NotFoundHttpException(sprintf('Panel "%s" is not available for token "%s".', $panel, $token));
        }

        return new Response(
            $this->twig->render("BeautyLogBundle:Collector:config.html.twig",
                array(
                    'token' => $token,
                    'profile' => $profile,
                    'collector' => $profile->getCollector($panel),
                    'panel' => $panel,
                    'page' => $page,
                    'request' => $request,
                    'is_ajax' => $request->isXmlHttpRequest(),
                )
            ),
            200,
            array('Content-Type' => 'text/html')
        );
    }


}
