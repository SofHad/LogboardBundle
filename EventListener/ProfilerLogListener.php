<?php

/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace So\LogboardBundle\EventListener;

use So\LogboardBundle\Exception\BadQueryHttpException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

/**
 * Profiler Listner
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class ProfilerLogListener implements EventSubscriberInterface
{
    /**
     * The request
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * A ControllerResolverInterface implementation knows how to determine the
     * controller to execute based on a Request object.
     * @var \Symfony\Component\HttpKernel\Controller\ControllerResolverInterface
     */
    private $controllerResolver;

    /**
     * The panel
     * @var string
     */
    private $panel;

    /**
     * The type
     * @var string
     */
    private $type;

    public function __construct(Request $request, ControllerResolverInterface $controllerResolver, $type, $panel)
    {
        if(null === $panel){
            throw new BadQueryHttpException("The panel must not be null");
        }

        $this->request = $request;
        $this->controllerResolver = $controllerResolver;
        $this->type = $type;
        $this->panel = $panel;
    }

    /**
     * {@inheritdoc}
     *
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => array('onKernelController', 5),
        );
    }

    /**
     * {@inheritdoc}
     *
     */
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

        $this->request->attributes->set('_controller', 'LogboardBundle:Profiler:panelLog');

        return $event->setController($this->controllerResolver->getController($this->request));
    }
}
