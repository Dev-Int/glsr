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

use Administration\Domain\Company\Command\CreateCompany;
use Administration\Domain\Company\CompanyFactory;
use Domain\Protocol\Common\Command\CommandHandlerProtocol;
use Administration\Domain\Protocol\Repository\CompanyRepositoryProtocol;

final class CreateCompanyHandler implements CommandHandlerProtocol
{
    private CompanyFactory $factory;
    private CompanyRepositoryProtocol $repository;

    public function __construct(CompanyFactory $factory, CompanyRepositoryProtocol $repository)
    {
        $this->factory = $factory;
        $this->repository = $repository;
    }

    public function __invoke(CreateCompany $command): void
    {
        if ($this->repository->companyExist()) {
            throw new \DomainException('A company is already create.');
        }
        if ($this->repository->existsWithName($command->name()->getValue())) {
            throw new \DomainException("Company with name: {$command->name()->getValue()} already exists.");
        }

        $company = $this->factory->create($command);

        $this->repository->add($company);
    }
}
