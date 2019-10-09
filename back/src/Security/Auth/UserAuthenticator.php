<?php
/**
 * Created by PhpStorm.
 * User: tymek
 * Date: 30.03.19
 * Time: 15:22
 */

namespace App\Security\Auth;


use App\Dto\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\User\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserAuthenticator
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function verify(UserDto $userDto)
    {
        /** @var User $user */
        $user = $this->userRepository->findOneBy(['username' => $userDto->getUsername()]);

        if(!$user) {
            throw new UserNotFoundException();
        }

        $auth = $this->passwordEncoder->isPasswordValid($user, $userDto->getPassword());

        if(!$auth) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
