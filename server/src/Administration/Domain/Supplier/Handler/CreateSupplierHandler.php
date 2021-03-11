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

use Administration\Domain\FamilyLog\Model\FamilyLog;
use Administration\Domain\Protocol\Repository\FamilyLogRepositoryProtocol;
use Administration\Domain\Protocol\Repository\SupplierRepositoryProtocol;
use Administration\Domain\Supplier\Command\CreateSupplier;
use Administration\Domain\Supplier\Model\Supplier;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;

class CreateSupplierHandler implements CommandHandlerProtocol
{
    private SupplierRepositoryProtocol $supplierRepository;
    private FamilyLogRepositoryProtocol $familyLogRepository;

    public function __construct(
        SupplierRepositoryProtocol $supplierRepository,
        FamilyLogRepositoryProtocol $familyLogRepository
    ) {
        $this->supplierRepository = $supplierRepository;
        $this->familyLogRepository = $familyLogRepository;
    }

    public function __invoke(CreateSupplier $command): void
    {
        if ($this->supplierRepository->existsWithName($command->name()->getValue())) {
            throw new \DomainException("Supplier with name: {$command->name()->getValue()} already exists.");
        }
        $familyLog = $this->familyLogRepository->findParent($command->familyLogUuid());

        $supplier = $this->createSupplier($command, $familyLog);

        $this->supplierRepository->add($supplier);
    }

    private function createSupplier(CreateSupplier $command, FamilyLog $familyLog): Supplier
    {
        return Supplier::create(
            ContactUuid::generate(),
            $command->name(),
            $command->address(),
            $command->zipCode(),
            $command->town(),
            $command->country(),
            $command->phone(),
            $command->facsimile(),
            $command->email(),
            $command->contact(),
            $command->cellPhone(),
            $familyLog,
            $command->delayDelivery(),
            $command->orderDays()
        );
    }
}
