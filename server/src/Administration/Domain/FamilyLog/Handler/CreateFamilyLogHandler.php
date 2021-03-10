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

use Administration\Domain\FamilyLog\Command\CreateFamilyLog;
use Administration\Domain\FamilyLog\Model\FamilyLog;
use Administration\Domain\FamilyLog\Model\VO\FamilyLogUuid;
use Administration\Domain\Protocol\Repository\FamilyLogRepositoryProtocol;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;

class CreateFamilyLogHandler implements CommandHandlerProtocol
{
    private FamilyLogRepositoryProtocol $repository;

    public function __construct(FamilyLogRepositoryProtocol $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateFamilyLog $command): void
    {
        $parent = null;
        $level = 1;
        if ($this->repository->existWithLabel($command->label()->getValue(), $command->parent())) {
            throw new \DomainException("FamilyLog with name: {$command->label()->getValue()} already exist!");
        }
        if (null !== $command->parent()) {
            $parent = $this->repository->findParent($command->parent());
            $level = $parent->level() + 1;
        }

        $familyLog = FamilyLog::create(
            FamilyLogUuid::generate(),
            $command->label(),
            $level,
            $parent
        );

        $this->repository->add($familyLog);
    }
}
