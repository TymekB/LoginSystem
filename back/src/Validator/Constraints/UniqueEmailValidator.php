<?php


namespace App\Validator\Constraints;


use App\Repository\UserRepository;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UniqueEmailValidator extends ConstraintValidator
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint)
    {
        if(!$constraint instanceof UniqueEmail) {
            throw new UnexpectedTypeException($constraint, UniqueEmail::class);
        }

        if($value === null || $value === '') {
            throw new UnexpectedValueException($value, 'string');
        }

        $user = $this->userRepository->findOneBy(['email' => $value]);

        if($user) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
