<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Repository\UserRepository;
use App\Security\Auth\UserAuthenticator;
use App\Security\Token\JsonWebToken;
use App\User\Exception\UserDataNotFoundException;
use App\User\Exception\UserNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api", name="api_")
 */
class UserController extends AbstractFOSRestController
{
    /**
     * @var JsonWebToken
     */
    private $jwt;
    /**
     * @var UserAuthenticator
     */
    private $userAuth;
    /**
     * @var UserRepository
     */
    private $userRepository;


    public function __construct(UserRepository $userRepository, UserAuthenticator $userAuth, JsonWebToken $jwt)
    {
        $this->jwt = $jwt;
        $this->userAuth = $userAuth;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws UserDataNotFoundException
     * @throws UserNotFoundException
     * @Rest\Post("/user/verify")
     */

    public function verify(Request $request)
    {
        $data = json_decode($request->getContent());

        if(!isset($data->username) || !isset($data->password)) {
            throw new UserDataNotFoundException();
        }

        $userDto = new UserDto();
        $userDto
            ->setUsername($data->username)
            ->setPassword($data->password);

        $user = $this->userAuth->verify($userDto);

        $tokenId = base64_encode(openssl_random_pseudo_bytes(32));
        $token = $this->jwt->encode($tokenId, ['apiToken' => $user->getApiToken()]);

        return $this->handleView($this->view(
            [
                'code' => Response::HTTP_OK,
                'data' => ['user' => $user, 'token' => $token]
            ]
        ));

    }

    /**
     * @Rest\Get("/user/find/username/{username}")
     * @param $username
     * @return Response
     */

    public function findByUsername($username)
    {
        $user = $this->userRepository->findBy(['username' => $username]);

        return $this->handleView($this->view(
            [
                'code' => Response::HTTP_OK,
                'data' => ['user' => $user ? $user : null]
            ]));
    }

    /**
     * @Rest\Get("/user/find/email/{email}")
     * @param $email
     * @return Response
     */
    public function findByEmail($email)
    {
        $user = $this->userRepository->findBy(['email' => $email]);

        return $this->handleView($this->view(
            [
                'code' => Response::HTTP_OK,
                'data' => ['user' => $user ? $user : null]
            ]));
    }
}
