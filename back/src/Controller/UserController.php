<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Security\Auth\UserAuthenticator;
use App\Security\Token\JsonWebToken;
use App\User\Exception\UserNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
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


    public function verify(Request $request)
    {
        $data = json_decode($request->getContent());

        $username = isset($data->username) ? $data->username : null;
        $password = isset($data->password) ? $data->password : null;

        $user = $this->userAuth->verify($username, $password);

        if(!$user) {
            return $this->json(['success' => false, 'message' => 'Wrong credentials']);
        }

        $tokenId = base64_encode(openssl_random_pseudo_bytes(32));
        $token = $this->jwt->encode($tokenId, ['apiToken' => $user->getApiToken()]);

        return $this->json([
            'success' => true,
            'user' => $user,
            'token' => $token
        ]);
    }

    public function findUsername($username)
    {
        $user = $this->userRepository->findBy(['username' => $username]);

        return $this->json([
            'success' => (bool)$user
        ]);
    }
}
