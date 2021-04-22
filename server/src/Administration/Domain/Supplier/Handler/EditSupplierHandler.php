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

namespace Administration\Domain\Supplier\Handler;

use Administration\Domain\Protocol\Repository\SupplierRepositoryProtocol;
use Administration\Domain\Supplier\Command\EditSupplier;
use Administration\Domain\Supplier\Model\Supplier;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;

class EditSupplierHandler implements CommandHandlerProtocol
{
    private SupplierRepositoryProtocol $repository;

    public function __construct(SupplierRepositoryProtocol $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(EditSupplier $command): void
    {
        $supplierToUpdate = $this->repository->findOneByUuid($command->uuid()->toString());

        if (null === $supplierToUpdate) {
            throw new \DomainException('Supplier provided does not exist!');
        }

        $supplier = $this->updateSupplier($command, $supplierToUpdate);

        $this->repository->save($supplier);
    }

    private function updateSupplier(EditSupplier $command, Supplier $supplier): Supplier
    {
        if ($supplier->companyName() !== $command->name()->getValue()) {
            $supplier->renameSupplier($command->name());
        }
        if ($supplier->address() !== $command->address()
            || ($supplier->zipCode() !== $command->zipCode())
            || ($supplier->town() !== $command->town())
            || ($supplier->country() !== $command->country())
        ) {
            $supplier->rewriteAddress([
                $command->address(),
                $command->zipCode(),
                $command->town(),
                $command->country(),
            ]);
        }
        if ($supplier->phone() !== $command->phone()->getValue()) {
            $supplier->changePhoneNumber($command->phone());
        }
        if ($supplier->facsimile() !== $command->facsimile()->getValue()) {
            $supplier->changeFacsimileNumber($command->facsimile());
        }
        if ($supplier->email() !== $command->email()->getValue()) {
            $supplier->rewriteEmail($command->email());
        }
        if ($supplier->contactName() !== $command->contact()) {
            $supplier->renameContact($command->contact());
        }
        if ($supplier->cellPhone() !== $command->cellPhone()->getValue()) {
            $supplier->changeCellphoneNumber($command->cellPhone());
        }
        if ($supplier->familyLog() !== $command->familyLog()->path()) {
            $supplier->reassignFamilyLog($command->familyLog());
        }
        if ($supplier->delayDelivery() !== $command->delayDelivery()) {
            $supplier->changeDelayDelivery($command->delayDelivery());
        }
        if ($supplier->orderDays() !== $command->orderDays()) {
            $supplier->reassignOrderDays($command->orderDays());
        }

        return $supplier;
    }
}
