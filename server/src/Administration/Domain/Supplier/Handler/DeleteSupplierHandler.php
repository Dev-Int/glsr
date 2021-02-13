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
use Administration\Domain\Supplier\Command\DeleteSupplier;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;

class DeleteSupplierHandler implements CommandHandlerProtocol
{
    private SupplierRepositoryProtocol $repository;

    public function __construct(SupplierRepositoryProtocol $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteSupplier $command): void
    {
        $supplierToDelete = $this->repository->findOneByUuid($command->uuid());

        if (null === $supplierToDelete) {
            throw new \DomainException('Supplier provided does not exist!');
        }

        $supplierToDelete->delete();
    }
}
