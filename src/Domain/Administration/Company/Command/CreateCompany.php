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

namespace Domain\Administration\Company\Command;

use Domain\Common\Model\VO\EmailField;
use Domain\Common\Model\VO\NameField;
use Domain\Common\Model\VO\PhoneField;
use Domain\Protocol\Common\Command\CommandProtocol;

final class CreateCompany implements CommandProtocol
{
    private NameField $name;
    private string $address;
    private string $zipCode;
    private string $town;
    private string $country;
    private PhoneField $phone;
    private PhoneField $facsimile;
    private EmailField $email;
    private string $contact;
    private PhoneField $gsm;

    public function __construct(
        NameField $name,
        string $address,
        string $zipCode,
        string $town,
        string $country,
        PhoneField $phone,
        PhoneField $facsimile,
        EmailField $email,
        string $contact,
        PhoneField $gsm
    ) {
        $this->name = $name;
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->town = $town;
        $this->country = $country;
        $this->phone = $phone;
        $this->facsimile = $facsimile;
        $this->email = $email;
        $this->contact = $contact;
        $this->gsm = $gsm;
    }

    public function name(): NameField
    {
        return $this->name;
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

    public function phone(): PhoneField
    {
        return $this->phone;
    }

    public function facsimile(): PhoneField
    {
        return $this->facsimile;
    }

    public function email(): EmailField
    {
        return $this->email;
    }

    public function contact(): string
    {
        return $this->contact;
    }

    public function gsm(): PhoneField
    {
        return $this->gsm;
    }
}
