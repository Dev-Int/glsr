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

use Administration\Domain\Supplier\Command\EditSupplier;
use Administration\Infrastructure\Persistence\DoctrineOrm\Entities\Supplier as SupplierEntity;
use Administration\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineSupplierRepository;
use Core\Domain\Protocol\Common\Command\CommandHandlerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;

class EditSupplierHandler implements CommandHandlerInterface
{
    private DoctrineSupplierRepository $repository;

    public function __construct(DoctrineSupplierRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws NonUniqueResultException
     * @throws ORMException
     */
    public function __invoke(EditSupplier $command): void
    {
        $supplierToUpdate = $this->repository->findOneByUuid($command->uuid()->toString());

        if (null === $supplierToUpdate) {
            throw new \DomainException('Supplier provided does not exist!');
        }

        $supplier = $this->updateSupplier($command, $supplierToUpdate);

        $this->repository->save($supplier);
    }

    private function updateSupplier(EditSupplier $command, SupplierEntity $supplier): SupplierEntity
    {
        $supplier->setCompanyName($command->name()->getValue());
        $supplier->setAddress($command->address());
        $supplier->setZipCode($command->zipCode());
        $supplier->setTown($command->town());
        $supplier->setCountry($command->country());
        $supplier->setPhone($command->phone()->getValue());
        $supplier->setFacsimile($command->facsimile()->getValue());
        $supplier->setEmail($command->email()->getValue());
        $supplier->setContactName($command->contactName());
        $supplier->setCellphone($command->cellphone()->getValue());
        $supplier->setFamilyLog($command->familyLog()->path());
        $supplier->setDelayDelivery($command->delayDelivery());
        $supplier->setOrderDays($command->orderDays());

        return $supplier;
    }
}
