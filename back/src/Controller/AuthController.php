<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Security\JsonWebToken;
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
     * @var JsonWebToken
     */
    private $jwt;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository, JsonWebToken $jwt)
    {
        $this->jwt = $jwt;
        $this->userRepository = $userRepository;
    }

    /**
     * @Rest\Get("/test")
     */
    public function test()
    {
        $response = $this->handleView($this->view(['protected data']));

        $response->headers->setCookie(new Cookie('test', 'test1'));

        return $response;
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

        $user = $this->userRepository->findOneByUsernameAndPassword($data->username, $data->password);

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
