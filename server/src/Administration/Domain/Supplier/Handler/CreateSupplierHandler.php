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
use Administration\Domain\Supplier\Command\CreateSupplier;
use Administration\Domain\Supplier\Model\Supplier;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;

class CreateSupplierHandler implements CommandHandlerProtocol
{
    private SupplierRepositoryProtocol $repository;

    public function __construct(SupplierRepositoryProtocol $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateSupplier $command): void
    {
        if ($this->repository->existsWithName($command->name()->getValue())) {
            throw new \DomainException("Supplier with name: {$command->name()->getValue()} already exists.");
        }

        $supplier = $this->createSupplier($command);

        $this->repository->add($supplier);
    }

    private function createSupplier(CreateSupplier $command): Supplier
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
            $command->familyLog(),
            $command->delayDelivery(),
            $command->orderDays()
        );
    }
}
