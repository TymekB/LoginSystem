<?php


namespace App\User\Exception;


use Throwable;

class UserDataNotValidException extends \Exception
{
    public function __construct(string $message = "Validation error", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
