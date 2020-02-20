<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\User\Exception\UserDataNotFoundException;
use App\User\Exception\UserDataNotValidException;
use App\User\Updater\UserUpdater;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class RegisterController extends AbstractFOSRestController
{
    /**
     * @var UserUpdater
     */
    private $updater;

    public function __construct(UserUpdater $updater)
    {
        $this->updater = $updater;
    }

    /**
     * @param Request $request
     * @Rest\Post("/register")
     * @return Response
     * @throws UserDataNotValidException
     * @throws UserDataNotFoundException
     */

    public function register(Request $request)
    {
        $data = json_decode($request->getContent());

        if (!isset($data->username) || !isset($data->email) || !isset($data->password)) {
            throw new UserDataNotFoundException();
        }

        $userDto = new UserDto();
        $userDto->setUsername($data->username)
            ->setEmail($data->email)
            ->setPassword($data->password);

        $this->updater->create($userDto);

        return $this->handleView($this->view(
            [
                'code' => Response::HTTP_OK,
                'message' => 'Your account was successfully created. You can now log in.'
            ]));
    }
}
