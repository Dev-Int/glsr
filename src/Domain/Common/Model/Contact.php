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

namespace Domain\Common\Model;

use Domain\Common\Model\VO\ContactAddress;
use Domain\Common\Model\VO\EmailField;
use Domain\Common\Model\VO\NameField;
use Domain\Common\Model\VO\PhoneField;

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
    protected string $contact;
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
        string $contact,
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
        $this->contact = $contact;
        $this->cellphone = $cellphone->getValue();
    }

    final public function uuid(): string
    {
        return $this->uuid;
    }

    final public function name(): string
    {
        return $this->name;
    }

    final public function fullAddress(): string
    {
        return ContactAddress::fromArray([$this->address, $this->zipCode, $this->town, $this->country])->getValue();
    }

    final public function rewriteAddress(array $addressData): void
    {
        $address = ContactAddress::fromArray($addressData);
        $this->address = $address->address();
        $this->zipCode = $address->zipCode();
        $this->town = $address->town();
        $this->country = $address->country();
    }

    final public function phone(): string
    {
        return $this->phone;
    }

    final public function changePhoneNumber(PhoneField $phone): void
    {
        $this->phone = $phone->getValue();
    }

    final public function facsimile(): string
    {
        return $this->facsimile;
    }

    final public function changeFacsimileNumber(PhoneField $facsimile): void
    {
        $this->facsimile = $facsimile->getValue();
    }

    final public function email(): string
    {
        return $this->email;
    }

    final public function rewriteEmail(EmailField $email): void
    {
        $this->email = $email->getValue();
    }

    final public function contact(): string
    {
        return $this->contact;
    }

    final public function renameContact(string $contact): void
    {
        $this->contact = $contact;
    }

    final public function cellphone(): string
    {
        return $this->cellphone;
    }

    final public function changeCellphoneNumber(PhoneField $cellphone): void
    {
        $this->cellphone = $cellphone->getValue();
    }

    final public function slug(): string
    {
        return $this->slug;
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
}
