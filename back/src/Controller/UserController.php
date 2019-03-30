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

    public function __construct(UserAuthenticator $userAuth, JsonWebToken $jwt)
    {
        $this->jwt = $jwt;
        $this->userAuth = $userAuth;
    }


    public function verify(Request $request)
    {
        $data = json_decode($request->getContent());

        $username = isset($data->username) ? $data->username : null;
        $password = isset($data->password) ? $data->password : null;

        $user = $this->userAuth->verify($username, $password);

        if(!$user) {
            throw new UserNotFoundException();
        }

        $tokenId = base64_encode(openssl_random_pseudo_bytes(32));
        $token = $this->jwt->encode($tokenId, ['test' => 123]);

        return $this->json([
            'user' => $user,
            'auth' => [
                'success' => true,
                'token' => $token
            ]
        ]);
    }
}
