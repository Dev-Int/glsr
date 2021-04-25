<?php

declare(strict_types=1);

/*
 * This file is part of the G.L.S.R. Apps package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Administration\Infrastructure\User\Handler;

use Administration\Domain\User\Command\EditUser;
use Administration\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineUserRepository;
use Core\Domain\Protocol\Common\Command\CommandHandlerInterface;
use Core\Infrastructure\Persistence\DoctrineOrm\Entities\User as UserSymfony;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EditUserHandler implements CommandHandlerInterface
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private DoctrineUserRepository $userRepository;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, DoctrineUserRepository $userRepository)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws NonUniqueResultException
     * @throws ORMException
     */
    public function __invoke(EditUser $command): void
    {
        $userToUpdate = $this->userRepository->findOneByUuid($command->uuid()->toString());

        if (null === $userToUpdate) {
            throw new \DomainException('User provided does not exist!');
        }

        $this->updateUser($command, $userToUpdate);
    }

    private function updateUser(EditUser $command, UserSymfony $user): UserSymfony
    {
        if ($user->getUsername() !== $command->username()) {
            $user->setUsername($command->username()->getValue());
        }
        if ($user->getEmail() !== $command->email()->getValue()) {
            $user->setEmail($command->email()->getValue());
        }

        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                $command->password()
            )
        );

        if ($user->getRoles() !== $command->roles()) {
            $user->setRoles($command->roles());
        }

        return $user;
    }
}
