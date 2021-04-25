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

use Administration\Domain\Supplier\Command\DeleteSupplier;
use Administration\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineSupplierRepository;
use Core\Domain\Protocol\Common\Command\CommandHandlerInterface;

class DeleteSupplierHandler implements CommandHandlerInterface
{
    private DoctrineSupplierRepository $repository;

    public function __construct(DoctrineSupplierRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteSupplier $command): void
    {
        $supplierToDelete = $this->repository->findOneByUuid($command->uuid());

        if (null === $supplierToDelete) {
            throw new \DomainException('Supplier provided does not exist!');
        }

        $this->repository->remove($supplierToDelete);
    }
}
