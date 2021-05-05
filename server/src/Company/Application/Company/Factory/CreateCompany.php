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

namespace Company\Application\Company\Factory;

use Company\Domain\Model\Company;
use Core\Domain\Common\Command\CommandInterface;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;

class CreateCompany
{
    public function createCompany(CommandInterface $commandCompany): Company
    {
        $contactUuid = null === $commandCompany->uuid() ? ContactUuid::generate() : ContactUuid::fromString(
            $commandCompany->uuid()
        );

        return Company::create(
            $contactUuid,
            NameField::fromString($commandCompany->companyName()),
            $commandCompany->address(),
            $commandCompany->zipCode(),
            $commandCompany->town(),
            $commandCompany->country(),
            PhoneField::fromString($commandCompany->phone()),
            PhoneField::fromString($commandCompany->facsimile()),
            EmailField::fromString($commandCompany->email()),
            $commandCompany->contactName(),
            PhoneField::fromString($commandCompany->cellphone())
        );
    }
}
