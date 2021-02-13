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

namespace Administration\Domain\Supplier\Command;

use Core\Domain\Common\Model\Dependent\FamilyLog;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;
use Core\Domain\Protocol\Common\Command\CommandProtocol;

class CreateSupplier implements CommandProtocol
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
    private PhoneField $cellPhone;
    private FamilyLog $familyLog;
    private int $delayDelivery;
    private array $orderDays;

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
        PhoneField $cellPhone,
        FamilyLog $familyLog,
        int $delayDelivery,
        array $orderDays
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
        $this->cellPhone = $cellPhone;
        $this->familyLog = $familyLog;
        $this->delayDelivery = $delayDelivery;
        $this->orderDays = $orderDays;
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

    public function cellPhone(): PhoneField
    {
        return $this->cellPhone;
    }

    public function familyLog(): FamilyLog
    {
        return $this->familyLog;
    }

    public function delayDelivery(): int
    {
        return $this->delayDelivery;
    }

    public function orderDays(): array
    {
        return $this->orderDays;
    }
}
