<?php

namespace AppBundle\EventListener;


use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $userAgent = $request->headers->get('User-Agent');
        $browser = $this->getBrowserName($userAgent);
        $request->attributes->set('browser', $userAgent);
        dump($this->container->get('router')->getRouteCollection()->all());
    }

    public function getBrowserName(string $u_agent)
    {
        $bname = "";
        if (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
        } elseif (preg_match('/Chromium/i', $u_agent)) {
            $bname = 'Chromium';
        } elseif (preg_match('/OPR/i', $u_agent)) {
            $bname = 'Opera';
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
        }
        return $bname;
    }
}