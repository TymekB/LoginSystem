<?php


namespace App\User\Exception;


use Throwable;

class UserDataNotFoundException extends \Exception
{
    public function __construct(string $message = "User data not found", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
