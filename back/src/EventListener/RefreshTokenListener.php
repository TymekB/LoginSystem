<?php


namespace App\EventListener;


use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;

class RefreshTokenListener
{
    /**
     * @var int
     */
    private $refreshTokenTtl;

    public function __construct(int $refreshTokenTtl)
    {
        $this->refreshTokenTtl = $refreshTokenTtl;
    }


    public function setRefreshToken(AuthenticationSuccessEvent $event)
    {
        $refreshToken = $event->getData()['refresh_token'];
        $response = $event->getResponse();

        $response->headers->setCookie(new Cookie('REFRESH_TOKEN', $refreshToken,
            (
                new \DateTime())->add(new \DateInterval('PT' . $this->refreshTokenTtl . 'S'))
            ));
    }
}