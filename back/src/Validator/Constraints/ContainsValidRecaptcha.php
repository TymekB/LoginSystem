<?php


namespace App\Validator\Constraints;
use Symfony\Component\Validator\Constraint;

class ContainsValidRecaptcha extends Constraint
{
    public $message = 'Recaptcha is not valid';
}