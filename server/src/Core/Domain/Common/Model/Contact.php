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

namespace Core\Domain\Common\Model;

use Core\Domain\Common\Model\VO\ContactAddress;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;

abstract class Contact
{
    protected string $uuid;
    protected string $name;
    protected string $address;
    protected string $zipCode;
    protected string $town;
    protected string $country;
    protected string $phone;
    protected string $facsimile;
    protected string $email;
    protected string $contactName;
    protected string $cellphone;
    protected string $slug;

    public function __construct(
        ContactUuid $uuid,
        NameField $name,
        string $address,
        string $zipCode,
        string $town,
        string $country,
        PhoneField $phone,
        PhoneField $facsimile,
        EmailField $email,
        string $contactName,
        PhoneField $cellphone
    ) {
        $this->uuid = $uuid->toString();
        $this->name = $name->getValue();
        $this->slug = $name->slugify();
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->town = $town;
        $this->country = $country;
        $this->phone = $phone->getValue();
        $this->facsimile = $facsimile->getValue();
        $this->email = $email->getValue();
        $this->contactName = $contactName;
        $this->cellphone = $cellphone->getValue();
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function fullAddress(): string
    {
        return ContactAddress::fromArray([$this->address, $this->zipCode, $this->town, $this->country])->getValue();
    }

    public function rewriteAddress(array $addressData): void
    {
        $address = ContactAddress::fromArray($addressData);
        $this->address = $address->address();
        $this->zipCode = $address->zipCode();
        $this->town = $address->town();
        $this->country = $address->country();
    }

    public function phone(): string
    {
        return $this->phone;
    }

    public function changePhoneNumber(PhoneField $phone): void
    {
        $this->phone = $phone->getValue();
    }

    public function facsimile(): string
    {
        return $this->facsimile;
    }

    public function changeFacsimileNumber(PhoneField $facsimile): void
    {
        $this->facsimile = $facsimile->getValue();
    }

    public function email(): string
    {
        return $this->email;
    }

    public function rewriteEmail(EmailField $email): void
    {
        $this->email = $email->getValue();
    }

    public function contactName(): string
    {
        return $this->contactName;
    }

    public function renameContact(string $contact): void
    {
        $this->contactName = $contact;
    }

    public function cellphone(): string
    {
        return $this->cellphone;
    }

    public function changeCellphoneNumber(PhoneField $cellphone): void
    {
        $this->cellphone = $cellphone->getValue();
    }

    public function slug(): string
    {
        return $this->slug;
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
}
