<?php


namespace App\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface
{

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => ['onRequest', 1]];
    }

    public function onRequest(GetResponseEvent $e)
    {
        $request = $e->getRequest();

        $cookies = $request->cookies;

        if(!$request->cookies->has('token')) {
            return;
        }
    }
}