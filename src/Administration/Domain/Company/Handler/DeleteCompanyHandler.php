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

namespace Administration\Domain\Company\Handler;

use Administration\Domain\Company\Command\DeleteCompany;
use Domain\Protocol\Common\Command\CommandHandlerProtocol;
use Domain\Protocol\Repository\CompanyRepositoryProtocol;

class DeleteCompanyHandler implements CommandHandlerProtocol
{
    private CompanyRepositoryProtocol $repository;

    public function __construct(CompanyRepositoryProtocol $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteCompany $command): void
    {
        $companyToDelete = $this->repository->findOneByUuid($command->uuid());

        if (null === $companyToDelete) {
            throw new \DomainException('Company provided does not exist !');
        }

        $this->repository->remove($companyToDelete);
    }
}
