<?php
/**
 * Created by PhpStorm.
 * User: tymek
 * Date: 30.03.19
 * Time: 15:22
 */

namespace App\Security\Auth;


use App\Entity\User;
use App\Repository\UserRepository;
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

    public function verify(string $username, string $password)
    {
        /** @var User $user */
        $user = $this->userRepository->findOneBy(['username' => $username]);

        if(!$user) {
            return false;
        }

        $auth = $this->passwordEncoder->isPasswordValid($user, $password);

        if(!$auth) {
            return false;
        }

        return $user;
    }
}
