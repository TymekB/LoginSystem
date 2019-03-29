<?php
/**
 * Created by PhpStorm.
 * User: tymek
 * Date: 25.03.19
 * Time: 19:50
 */

namespace App\User\Exception;


use Throwable;

class UserNotFoundException extends \Exception
{
    public function __construct(string $message = "Wrong credentials", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
