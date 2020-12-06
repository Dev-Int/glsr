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
            $command->gsm()
        );
    }
}
