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

namespace Administration\Application\Supplier\ReadModel;

use Core\Domain\Common\Model\VO\ContactAddress;

final class Supplier
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
    private string $familyLog;
    private int $delayDelivery;
    private array $orderDays;
    private string $slug;
    private bool $active;

    public function __construct(
        string $uuid,
        string $companyName,
        string $address,
        string $zipCode,
        string $town,
        string $country,
        string $phone,
        string $facsimile,
        string $email,
        string $contact,
        string $cellphone,
        string $familyLog,
        int $delayDelivery,
        array $orderDays,
        string $slug,
        bool $active = true
    ) {
        $this->uuid = $uuid;
        $this->companyName = $companyName;
        $this->slug = $slug;
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->town = $town;
        $this->country = $country;
        $this->phone = $phone;
        $this->facsimile = $facsimile;
        $this->email = $email;
        $this->contact = $contact;
        $this->cellphone = $cellphone;
        $this->familyLog = $familyLog;
        $this->delayDelivery = $delayDelivery;
        $this->orderDays = $orderDays;
        $this->active = $active;
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

    public function fullAddress(): string
    {
        return ContactAddress::fromArray([$this->address, $this->zipCode, $this->town, $this->country])->getValue();
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

    public function familyLog(): string
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

    public function slug(): string
    {
        return $this->slug;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
