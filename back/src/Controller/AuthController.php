<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Security\Auth\UserAuthenticator;
use App\Security\Token\JsonWebToken;
use App\User\Exception\UserDataNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\User\Exception\UserNotFoundException;

/**
 * @Route("/api", name="api_")
 */
class AuthController extends AbstractFOSRestController
{
    /**
     * @var UserAuthenticator
     */
    private $userAuth;
    /**
     * @var JsonWebToken
     */
    private $jwt;

    public function __construct(UserAuthenticator $userAuth, JsonWebToken $jwt)
    {
        $this->userAuth = $userAuth;
        $this->jwt = $jwt;
    }


    /**
     * @Rest\Post("/auth")
     * @param Request $request
     * @return Response
     * @throws UserDataNotFoundException
     * @throws UserNotFoundException
     */
    public function index(Request $request)
    {
        $data = json_decode($request->getContent());

        if (!isset($data->username) || !isset($data->password)) {
            throw new UserDataNotFoundException();
        }

        $userDto = new UserDto();
        $userDto
            ->setUsername($data->username)
            ->setPassword($data->password);

        $user = $this->userAuth->verify($userDto);

        $tokenId = base64_encode(openssl_random_pseudo_bytes(32));
        $token = $this->jwt->encode($tokenId, ['token' => $user->getApiToken()]);

        $response = $this->handleView($this->view(
            [
                'code' => Response::HTTP_OK,
                'data' => ['user' => $user]
            ]));

        $response->headers->setCookie(new Cookie('token', $token));

        return $response;
    }
}
