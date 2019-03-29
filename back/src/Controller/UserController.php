<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\User\Exception\UserNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }


    public function verify(Request $request)
    {
        $data = json_decode($request->getContent());

        $username = isset($data->username) ? $data->username : null;
        $password = isset($data->password) ? $data->password : null;

        /** @var UserInterface $user */
        $user = $this->userRepository->findOneBy(['username' => $username]);

        if (!$user) {
            throw new UserNotFoundException();
        }

        $auth = $this->passwordEncoder->isPasswordValid($user, $password);

        if(!$auth) {
            throw new UserNotFoundException();
        }

        return $this->json(['user' => $user, 'authenticated' => true]);
    }
}
