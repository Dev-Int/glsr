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

namespace Domain\Administration\Company;

use Domain\Administration\Company\Command\CreateCompany;
use Domain\Administration\Company\Command\EditCompany;
use Domain\Administration\Company\Model\Company;
use Domain\Common\Model\ContactUuid;

final class CompanyFactory
{
    public function create(CreateCompany $command): Company
    {
        return Company::create(
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
            $command->cellPhone()
        );
    }

    public function update(EditCompany $command, Company $company): Company
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
