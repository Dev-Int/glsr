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

use Administration\Domain\User\Command\DeleteUser;
use Administration\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineUserRepository;
use Core\Domain\Protocol\Common\Command\CommandHandlerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;

final class DeleteUserHandler implements CommandHandlerInterface
{
    private DoctrineUserRepository $repository;

    public function __construct(DoctrineUserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws NonUniqueResultException
     * @throws ORMException
     */
    public function __invoke(DeleteUser $command): void
    {
        $userToDelete = $this->repository->findOneByUuid($command->uuid());

        if (null === $userToDelete) {
            throw new \DomainException('User provided does not exist!');
        }

        $this->repository->remove($userToDelete);
    }
}
