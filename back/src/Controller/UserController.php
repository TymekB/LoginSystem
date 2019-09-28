<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\Auth\UserAuthenticator;
use App\Security\Token\JsonWebToken;
use App\User\Exception\UserNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em, UserAuthenticator $userAuth, JsonWebToken $jwt, UserPasswordEncoderInterface $encoder, ValidatorInterface $validator)
    {
        $this->jwt = $jwt;
        $this->userAuth = $userAuth;
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->encoder = $encoder;
        $this->validator = $validator;
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

    public function findByUsername($username)
    {
        $user = $this->userRepository->findBy(['username' => $username]);

        return $this->json([
            'user' => ($user) ? $user : null,
            'success' => (bool)$user
        ]);
    }

    public function findByEmail($email)
    {
        $user = $this->userRepository->findBy(['email' => $email]);

        return $this->json([
           'user' => ($user) ? $user : null,
           'success' => (bool)$user
        ]);
    }

    public function register(Request $request)
    {
        $data = json_decode($request->getContent());

        $username = (isset($data->username)) ? $data->username : null;
        $email = (isset($data->email)) ? $data->email : null;
        $password = (isset($data->password)) ? $data->password : null;

        $user = new User();

        $apiToken = bin2hex(random_bytes(16));
        $passwordHash = $this->encoder->encodePassword($user, $password);

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setApiToken($apiToken);

        $errors = $this->validator->validate($user);

        $user->setPassword($passwordHash);

        if(count($errors) > 0) {
            return $this->json(['success' => false, 'error_message' => 'validation error']);
        }

        $this->em->persist($user);
        $this->em->flush();

        return $this->json(['success' => true]);
    }

}
