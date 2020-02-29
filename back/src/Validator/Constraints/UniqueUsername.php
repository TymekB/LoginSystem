<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class UniqueUsername extends Constraint
{
    public $message = 'The username {{ string }} is taken';
}
