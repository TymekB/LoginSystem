<?php

namespace App\Controller;

use App\Repository\UserRepository;
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
     * @var UserRepository
     */
    private $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Rest\Get("/test")
     * @return Response
     */
    public function test()
    {
        return $this->handleView($this->view(['protected data']));
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
