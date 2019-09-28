<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends AbstractController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(UserPasswordEncoderInterface $encoder, ValidatorInterface $validator, EntityManagerInterface $em)
    {

        $this->encoder = $encoder;
        $this->validator = $validator;
        $this->em = $em;
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
