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

namespace Administration\Domain\FamilyLog\Handler;

use Administration\Domain\FamilyLog\Command\DeleteFamilyLog;
use Administration\Domain\Protocol\Repository\FamilyLogRepositoryProtocol;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;

class DeleteFamilyLogHandler implements CommandHandlerProtocol
{
    private FamilyLogRepositoryProtocol $repository;

    public function __construct(FamilyLogRepositoryProtocol $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteFamilyLog $command): void
    {
        $familyLogToDelete = $this->repository->findChildren($command->uuid());

        if (true === $familyLogToDelete->hasChildren()) {
            throw new \DomainException('This FamilyLog has children, and cannot be deleted');
        }

        $this->repository->delete($familyLogToDelete->uuid());
    }
}
