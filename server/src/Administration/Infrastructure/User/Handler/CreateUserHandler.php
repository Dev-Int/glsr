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

use Administration\Domain\User\Command\CreateUser;
use Administration\Domain\User\Model\VO\UserUuid;
use Administration\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineUserRepository;
use Core\Domain\Model\User;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserHandler implements CommandHandlerProtocol
{
    private DoctrineUserRepository $repository;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(DoctrineUserRepository $repository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->repository = $repository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function __invoke(CreateUser $command): void
    {
        if ($this->repository->existWithUsername($command->username()->getValue())) {
            throw new \DomainException("User with username: {$command->username()->getValue()} already exist");
        }
        if ($this->repository->existWithEmail($command->email()->getValue())) {
            throw new \DomainException("User with email: {$command->email()->getValue()} already exist");
        }

        $user = User::create(
            UserUuid::generate(),
            $command->username(),
            $command->email(),
            $command->password(),
            $command->roles()
        );
        $user->changePassword(
            $this->passwordEncoder->encodePassword(
                $user,
                $command->password()
            )
        );

        $this->repository->add($user);
    }
}
