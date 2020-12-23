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
use Administration\Domain\User\Command\DeleteUser;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;

final class DeleteUserHandler implements CommandHandlerProtocol
{
    private UserRepositoryProtocol $repository;

    public function __construct(UserRepositoryProtocol $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteUser $command): void
    {
        $userToDelete = $this->repository->findOneByUuid($command->uuid());

        if (null === $userToDelete) {
            throw new \DomainException('User provided does not exist!');
        }

        $this->repository->remove($userToDelete);
    }
}
