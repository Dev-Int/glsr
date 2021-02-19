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

final class Supplier
{
    public string $uuid;
    public string $name;
    public string $address;
    public string $zipCode;
    public string $town;
    public string $country;
    public string $phone;
    public string $facsimile;
    public string $email;
    public string $contact;
    public string $cellphone;
    public string $familyLog;
    public int $delayDelivery;
    public array $orderDays;
    public string $slug;
    public bool $active;

    public function __construct(
        string $uuid,
        string $name,
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
        $this->name = $name;
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
}
