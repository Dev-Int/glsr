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

namespace Administration\Domain\User\Handler;

use Administration\Domain\Protocol\Repository\UserRepositoryProtocol;
use Administration\Domain\User\Command\CreateUser;
use Administration\Domain\User\Model\User;
use Administration\Domain\User\Model\VO\UserUuid;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;

final class CreateUserHandler implements CommandHandlerProtocol
{
    private UserRepositoryProtocol $repository;

    public function __construct(UserRepositoryProtocol $repository)
    {
        $this->repository = $repository;
    }

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

        $this->repository->add($user);
    }
}
