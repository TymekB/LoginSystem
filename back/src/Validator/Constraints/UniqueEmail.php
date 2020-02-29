<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class UniqueEmail extends Constraint
{
    public $message = 'Account with email {{ string }} already exists';
}
