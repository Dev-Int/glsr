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

use Administration\Domain\FamilyLog\Command\EditFamilyLog;
use Administration\Domain\FamilyLog\Model\FamilyLog;
use Administration\Domain\Protocol\Repository\FamilyLogRepositoryProtocol;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;

class EditFamilyLogHandler implements CommandHandlerProtocol
{
    private FamilyLogRepositoryProtocol $repository;

    public function __construct(FamilyLogRepositoryProtocol $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(EditFamilyLog $command): void
    {
        if ($this->repository->existWithLabel($command->label()->getValue(), $command->parent())) {
            throw new \DomainException("FamilyLog with name: {$command->label()->getValue()} already exist!");
        }

        $familyLogToUpdate = $this->repository->findParent($command->uuid()->toString());

        $familyLog = $this->updateFamilyLog($familyLogToUpdate, $command);

        $this->repository->update($familyLog);
    }

    private function updateFamilyLog(FamilyLog $familyLog, EditFamilyLog $command): FamilyLog
    {
        $parent = null;
        if ($familyLog->label() !== $command->label()->getValue()) {
            $familyLog->rename($command->label());
        }

        if (null !== $command->parent()) {
            $parent = $this->repository->findParent($command->parent());
            if ((null !== $familyLog->parent()) && ($familyLog->parent()->uuid() !== $parent->uuid())) {
                $familyLog->attributeParent($parent);
            } else {
                $familyLog->attributeParent($parent);
            }
        } elseif (null === $command->parent() && null !== $familyLog->parent()) {
            $familyLog->attributeParent($parent);
        }

        return $familyLog;
    }
}
