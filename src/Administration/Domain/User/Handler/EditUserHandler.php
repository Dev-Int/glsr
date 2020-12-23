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
use Administration\Domain\User\Command\EditUser;
use Administration\Domain\User\Model\User;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;

final class EditUserHandler implements CommandHandlerProtocol
{
    private UserRepositoryProtocol $repository;

    public function __construct(UserRepositoryProtocol $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(EditUser $command): void
    {
        $userToUpdate = $this->repository->findOneByUuid($command->uuid()->toString());

        if (null === $userToUpdate) {
            throw new \DomainException('User provided does not exist!');
        }

        $this->updateUser($command, $userToUpdate);
    }

    private function updateUser(EditUser $command, User $user): User
    {
        if ($user->username() !== $command->username()) {
            $user->renameUser($command->username());
        }
        if ($user->email() !== $command->email()) {
            $user->changeEmail($command->email());
        }
        if ($user->password() !== $command->password()) {
            $user->changePassword($command->password());
        }
        if ($user->roles() !== $command->roles()) {
            $user->assignRoles($command->roles());
        }

        return $user;
    }
}
