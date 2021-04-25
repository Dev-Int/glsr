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
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;
use Core\Domain\Protocol\Common\Command\CommandInterface;

class EditSupplier implements CommandInterface
{
    private ContactUuid $uuid;
    private NameField $name;
    private string $address;
    private string $zipCode;
    private string $town;
    private string $country;
    private PhoneField $phone;
    private PhoneField $facsimile;
    private EmailField $email;
    private string $contactName;
    private PhoneField $cellphone;
    private FamilyLog $familyLog;
    private int $delayDelivery;
    private array $orderDays;

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
        PhoneField $cellphone,
        FamilyLog $familyLog,
        int $delayDelivery,
        array $orderDays
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->town = $town;
        $this->country = $country;
        $this->phone = $phone;
        $this->facsimile = $facsimile;
        $this->email = $email;
        $this->contactName = $contactName;
        $this->cellphone = $cellphone;
        $this->familyLog = $familyLog;
        $this->delayDelivery = $delayDelivery;
        $this->orderDays = $orderDays;
    }

    public function uuid(): ContactUuid
    {
        return $this->uuid;
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

    public function contactName(): string
    {
        return $this->contactName;
    }

    public function cellphone(): PhoneField
    {
        return $this->cellphone;
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
