<?php

declare(strict_types=1);

/*
 * This file is part of the Tests package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Domain\Model;

use Domain\Model\Common\VO\ContactAddress;
use Domain\Model\Common\VO\EmailField;
use Domain\Model\Common\VO\NameField;
use Domain\Model\Common\VO\PhoneField;

class Contact
{
    protected string $uuid;
    protected string $name;
    protected string $address;
    protected string $phone;
    protected string $facsimile;
    protected string $email;
    protected string $contact;
    protected string $cellphone;
    protected string $slug;

    public function __construct(
        ContactUuid $uuid,
        NameField $name,
        ContactAddress $address,
        PhoneField $phone,
        PhoneField $facsimile,
        EmailField $email,
        string $contact,
        PhoneField $cellphone
    ) {
        $this->uuid = $uuid->toString();
        $this->name = $name->getValue();
        $this->address = $address->getValue();
        $this->phone = $phone->getValue();
        $this->facsimile = $facsimile->getValue();
        $this->email = $email->getValue();
        $this->contact = $contact;
        $this->cellphone = $cellphone->getValue();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function renameContact(NameField $name): void
    {
        $this->name = $name->getValue();
        $this->slug = $name->slugify();
    }

    public function address(): string
    {
        return $this->address;
    }

    public function rewriteAddress(ContactAddress $address): void
    {
        $this->address = $address->getValue();
    }

    public function phone(): string
    {
        return $this->phone;
    }

    public function changePhoneNumber(string $phone): void
    {
        $this->phone = $phone;
    }

    public function facsimile(): string
    {
        return $this->facsimile;
    }

    public function changeFacsimileNumber(string $facsimile): void
    {
        $this->facsimile = $facsimile;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function rewriteEmail(EmailField $email): void
    {
        $this->email = $email->getValue();
    }

    public function contact(): string
    {
        return $this->contact;
    }

    public function setContact(string $contact): void
    {
        $this->contact = $contact;
    }

    public function cellphone(): string
    {
        return $this->cellphone;
    }

    public function changeCellphoneNumber(string $cellphone): void
    {
        $this->cellphone = $cellphone;
    }

    public function slug(): string
    {
        return $this->slug;
    }
}
