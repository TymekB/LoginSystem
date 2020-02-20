<?php


namespace App\User\Updater;


use App\Dto\UserDto;
use App\Entity\User;
use App\User\Exception\UserDataNotValidException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserUpdater
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->encoder = $encoder;
    }

    /**
     * @param UserDto $userDto
     * @return bool
     * @throws UserDataNotValidException
     */
    public function create(UserDto $userDto)
    {
        $user = User::createFromDto($userDto);

        $errors = $this->validator->validate($user);

        if(count($errors)) {
            throw new UserDataNotValidException();
        }

        $passwordHash = $this->encoder->encodePassword($user, $userDto->getPassword());
        $user->setPassword($passwordHash);

//        $this->em->persist($user);
//        $this->em->flush();

        return true;
    }

}
