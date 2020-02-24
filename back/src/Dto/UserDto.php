<?php


namespace App\Dto;


class UserDto
{
    private $username;
    private $email;
    private $password;
    private $recaptcha;

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

    /**
     * @return mixed
     */
    public function getRecaptcha()
    {
        return $this->recaptcha;
    }

    /**
     * @param mixed $recaptcha
     * @return UserDto
     */
    public function setRecaptcha($recaptcha): self
    {
        $this->recaptcha = $recaptcha;

        return $this;
    }

}
