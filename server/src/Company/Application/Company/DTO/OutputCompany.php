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

namespace Company\Application\Company\DTO;

use Company\Domain\Model\Company;

class OutputCompany
{
    private string $uuid;
    private string $companyName;
    private string $address;
    private string $zipCode;
    private string $town;
    private string $country;
    private string $phone;
    private string $facsimile;
    private string $email;
    private string $contact;
    private string $cellphone;

    public function __construct(Company $company)
    {
        $this->uuid = $company->uuid();
        $this->companyName = $company->contactName();
        $this->address = $company->address();
        $this->zipCode = $company->zipCode();
        $this->town = $company->town();
        $this->country = $company->country();
        $this->phone = $company->phone();
        $this->facsimile = $company->facsimile();
        $this->email = $company->email();
        $this->contact = $company->contactName();
        $this->cellphone = $company->cellphone();
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function companyName(): string
    {
        return $this->companyName;
    }

    public function address(): string
    {
        return $this->address;
    }

    public function zipCode(): string
    {
        return $this->zipCode;
    }

    public function town(): string
    {
        return $this->town;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function phone(): string
    {
        return $this->phone;
    }

    public function facsimile(): string
    {
        return $this->facsimile;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function contact(): string
    {
        return $this->contact;
    }

    public function cellphone(): string
    {
        return $this->cellphone;
    }
}
