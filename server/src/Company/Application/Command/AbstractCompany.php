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

namespace Company\Application\Command;

use Core\Domain\Protocol\Common\Command\CommandInterface;

abstract class AbstractCompany implements CommandInterface
{
    public ?string $uuid;
    private string $companyName;
    private string $address;
    private string $zipCode;
    private string $town;
    private string $country;
    private string $phone;
    private string $facsimile;
    private string $email;
    private string $contactName;
    private string $cellPhone;

    public function __construct(
        string $companyName,
        string $address,
        string $zipCode,
        string $town,
        string $country,
        string $phone,
        string $facsimile,
        string $email,
        string $contactName,
        string $cellphone,
        ?string $uuid = null
    ) {
        $this->uuid = $uuid;
        $this->companyName = $companyName;
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->town = $town;
        $this->country = $country;
        $this->phone = $phone;
        $this->facsimile = $facsimile;
        $this->email = $email;
        $this->contactName = $contactName;
        $this->cellPhone = $cellphone;
    }

    final public function companyName(): string
    {
        return $this->companyName;
    }

    final public function address(): string
    {
        return $this->address;
    }

    final public function zipCode(): string
    {
        return $this->zipCode;
    }

    final public function town(): string
    {
        return $this->town;
    }

    final public function country(): string
    {
        return $this->country;
    }

    final public function phone(): string
    {
        return $this->phone;
    }

    final public function facsimile(): string
    {
        return $this->facsimile;
    }

    final public function email(): string
    {
        return $this->email;
    }

    final public function contactName(): string
    {
        return $this->contactName;
    }

    final public function cellphone(): string
    {
        return $this->cellPhone;
    }

    final public function uuid(): ?string
    {
        return $this->uuid;
    }
}
