<?php

namespace AppBundle\EventListener;



use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;


class TwigGlobalListener
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $global = $request->get("global");
        if (empty($global)) {
            $this->container->get('twig')->addGlobal($global, $global);
        }

    }

}