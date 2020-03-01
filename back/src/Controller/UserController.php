<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\User\Exception\UserDataNotFoundException;
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
     * @Rest\Get("/user")
     * @param string $value
     * @param Request $request
     * @return Response
     * @throws UserDataNotFoundException
     */
    public function find(Request $request)
    {
        $value = $request->query->get('v');
        $findBy = $request->query->get('findBy');

        if($value === null || $findBy === null || $findBy !== 'username' && $findBy !== 'email') {
            throw new UserDataNotFoundException();
        }

        $user = $this->userRepository->findBy([$findBy => $value]);

        return $this->handleView($this->view(
            [
                'code' => Response::HTTP_OK,
                'data' => ['userFound' => (bool)$user]
            ]));
    }
}
