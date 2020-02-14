<?php


namespace App\EventListener;


use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
    public function onRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $refreshToken = $request->cookies->get('REFRESH_TOKEN');
        $request->request->set('refresh_token', $refreshToken);
    }
}