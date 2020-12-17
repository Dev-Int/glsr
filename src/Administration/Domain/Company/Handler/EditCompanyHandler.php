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

use Administration\Domain\Company\Command\EditCompany;
use Administration\Domain\Company\CompanyFactory;
use Domain\Protocol\Common\Command\CommandHandlerProtocol;
use Administration\Domain\Protocol\Repository\CompanyRepositoryProtocol;

final class EditCompanyHandler implements CommandHandlerProtocol
{
    private CompanyFactory $factory;
    private CompanyRepositoryProtocol $repository;

    public function __construct(CompanyFactory $factory, CompanyRepositoryProtocol $repository)
    {
        $this->factory = $factory;
        $this->repository = $repository;
    }

    public function __invoke(EditCompany $command): void
    {
        $companyToUpdate = $this->repository->findOneByUuid($command->uuid());

        if (null === $companyToUpdate) {
            throw new \DomainException('Company provided does not exist !');
        }
        $company = $this->factory->update($command, $companyToUpdate);

        $this->repository->add($company);
    }
}
