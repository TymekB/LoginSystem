<?php

namespace App\Controller;

use App\User\Updater\UserUpdater;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends AbstractController
{
    /**
     * @var UserUpdater
     */
    private $updater;

    public function __construct(UserUpdater $updater)
    {
        $this->updater = $updater;
    }

    public function register(Request $request)
    {
        $data = json_decode($request->getContent());

        $username = (isset($data->username)) ? $data->username : null;
        $email = (isset($data->email)) ? $data->email : null;
        $password = (isset($data->password)) ? $data->password : null;
        $apiToken = bin2hex(random_bytes(16));

        $userCreated = $this->updater->create($username, $email, $password, $apiToken);

        if(!$userCreated) {
            return $this->json(['success' => false, 'message' => 'validation error']);
        }

        return $this->json(
            [
                'success' => true,
                'message' => "Your account was successfully created. You can now log in."
            ]);
    }
}
