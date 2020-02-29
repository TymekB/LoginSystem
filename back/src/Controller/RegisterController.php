<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Entity\User;
use App\Form\Type\UserType;
use App\User\Exception\UserDataNotFoundException;
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
     * @throws UserDataNotFoundException
     */

    public function register(Request $request)
    {
        $data = json_decode($request->getContent());

        if (!isset($data->user->username) || !isset($data->user->password) || !isset($data->user->email) ||
            !isset($data->user->recaptcha)) {

            throw new UserDataNotFoundException();
        }

        $userDto = new UserDto();

        $form = $this->createForm(UserType::class, $userDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = User::createFromDto($userDto);
            $this->updater->create($user);
        }

        return $this->handleView($this->view($form));
    }
}
