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

namespace Administration\Infrastructure\Company\Mapper;

use Administration\Application\Company\ReadModel\Company as CompanyReadModel;
use Administration\Domain\Company\Model\Company;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;

class CompanyModelMapper
{
    public function getReadModelFromArray(array $data): CompanyReadModel
    {
        return new CompanyReadModel(
            $data['uuid'],
            $data['name'],
            $data['address'],
            $data['zip_code'],
            $data['town'],
            $data['country'],
            $data['phone'],
            $data['facsimile'],
            $data['email'],
            $data['contact_name'],
            $data['cellphone'],
            $data['slug']
        );
    }

    public function getDomainModelFromArray(array $data): Company
    {
        return Company::create(
            ContactUuid::fromString($data['uuid']),
            NameField::fromString($data['name']),
            $data['address'],
            $data['zip_code'],
            $data['town'],
            $data['country'],
            PhoneField::fromString($data['phone']),
            PhoneField::fromString($data['facsimile']),
            EmailField::fromString($data['email']),
            $data['contact_name'],
            PhoneField::fromString($data['cellphone'])
        );
    }

    public function getDataFromCompany(Company $company): array
    {
        return [
            'uuid' => $company->uuid(),
            'name' => $company->name(),
            'address' => $company->address(),
            'zip_code' => $company->zipCode(),
            'town' => $company->town(),
            'country' => $company->country(),
            'phone' => $company->phone(),
            'facsimile' => $company->facsimile(),
            'email' => $company->email(),
            'contact_name' => $company->contact(),
            'cellphone' => $company->cellphone(),
            'slug' => $company->slug(),
        ];
    }
}
