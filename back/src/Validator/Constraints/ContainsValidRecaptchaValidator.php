<?php


namespace App\Validator\Constraints;


use ReCaptcha\ReCaptcha;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ContainsValidRecaptchaValidator extends ConstraintValidator
{
    /**
     * @var ReCaptcha
     */
    private $reCaptcha;

    public function __construct(ReCaptcha $reCaptcha)
    {
        $this->reCaptcha = $reCaptcha;
    }
    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint)
    {
        if(!$constraint instanceof ContainsValidRecaptcha) {
             throw new UnexpectedTypeException($constraint, ContainsValidRecaptcha::class);
        }

        if(!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $response = $this->reCaptcha->verify($value);

        if(!$response->isSuccess()) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}