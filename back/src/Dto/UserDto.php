<?php


namespace App\Dto;


class UserDto
{
    private $username;
    private $email;
    private $password;
    private $apiToken;

    /**
     * @return mixed
     */
    public function getApiToken()
    {
        return $this->apiToken;
    }

    /**
     * @param mixed $apiToken
     * @return UserDto
     */
    public function setApiToken($apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return UserDto
     */
    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return UserDto
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return UserDto
     */
    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

}
