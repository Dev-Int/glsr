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
use Administration\Domain\Company\Model\Company;
use Administration\Domain\Protocol\Repository\CompanyRepositoryProtocol;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;
use Doctrine\DBAL\Driver\Exception;

final class EditCompanyHandler implements CommandHandlerProtocol
{
    private CompanyRepositoryProtocol $repository;

    public function __construct(CompanyRepositoryProtocol $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function __invoke(EditCompany $command): void
    {
        $companyToUpdate = $this->repository->findOneByUuid($command->uuid());

        if (null === $companyToUpdate) {
            throw new \DomainException('Company provided does not exist !');
        }
        $company = $this->updateCompany($command, $companyToUpdate);

        $this->repository->update($company);
    }

    public function updateCompany(EditCompany $command, Company $company): Company
    {
        if ($company->name() !== $command->name()) {
            $company->renameCompany($command->name());
        }
        if (($company->address() !== $command->address())
            || ($company->zipCode() !== $command->zipCode())
            || ($company->town() !== $command->town())
            || ($company->country() !== $command->country())
        ) {
            $company->rewriteAddress([
                $command->address(),
                $command->zipCode(),
                $command->town(),
                $command->country(),
            ]);
        }
        if ($company->phone() !== $command->phone()) {
            $company->changePhoneNumber($command->phone());
        }
        if ($company->facsimile() !== $command->facsimile()) {
            $company->changeFacsimileNumber($command->facsimile());
        }
        if ($company->email() !== $command->email()) {
            $company->rewriteEmail($command->email());
        }
        if ($company->contact() !== $command->contact()) {
            $company->renameContact($command->contact());
        }
        if ($company->cellPhone() !== $command->cellPhone()) {
            $company->changeCellphoneNumber($command->cellPhone());
        }

        return $company;
    }
}
