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
use Administration\Domain\Company\Model\Company;
use Administration\Domain\Protocol\Repository\CompanyRepositoryProtocol;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;

final class CreateCompanyHandler implements CommandHandlerProtocol
{
    private CompanyRepositoryProtocol $repository;

    public function __construct(CompanyRepositoryProtocol $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateCompany $command): void
    {
        if (false !== $this->repository->companyExist()) {
            throw new \DomainException('A company is already create.');
        }
        if ($this->repository->existsWithName($command->companyName()->getValue())) {
            throw new \DomainException("Company with name: {$command->companyName()->getValue()} already exists.");
        }

        $company = $this->createCompany($command);

        $this->repository->save($company);
    }

    public function createCompany(CreateCompany $command): Company
    {
        return Company::create(
            ContactUuid::generate(),
            $command->companyName(),
            $command->address(),
            $command->zipCode(),
            $command->town(),
            $command->country(),
            $command->phone(),
            $command->facsimile(),
            $command->email(),
            $command->contact(),
            $command->cellPhone()
        );
    }
}
