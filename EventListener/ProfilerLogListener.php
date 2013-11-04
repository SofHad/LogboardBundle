<?php

/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace So\BeautyLogBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ProfilerLogListener implements EventSubscriberInterface
{
    private $request;
    private $controllerResolver;
    private $panel;
    private $type;

    public function __construct(Request $request, $controllerResolver, $type, $panel)
    {
        $this->request = $request;
        $this->controllerResolver = $controllerResolver;
        $this->type = $type;
        $this->panel = $panel;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => array('onKernelController', 5),
        );
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        $type = $controller[1];

        if ($this->type !== $type) {
            return;
        }

        if ($this->panel !== $this->request->query->get("panel")) {
            return;
        }

        $this->request->attributes->set('_controller', 'BeautyLogBundle:Profiler:panelLog');
        return $event->setController($this->controllerResolver->getController($this->request));
    }
}
