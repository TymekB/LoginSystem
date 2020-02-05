<?php


namespace App\EventListener;



use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;

class AuthenticationSuccessListener
{
    private $tokenTtl;

    public function __construct(int $tokenTtl)
    {
        $this->tokenTtl = $tokenTtl;
    }


    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $response = $event->getResponse();
        $data = $event->getData();

        $data['user'] = $event->getUser();
        $event->setData($data);

        $token = $data['token'];
        $response->headers->setCookie(new Cookie('BEARER', $token,
            (
                new \DateTime())->add(new \DateInterval('PT' . $this->tokenTtl . 'S'))
            ));

        return $response;
    }
}