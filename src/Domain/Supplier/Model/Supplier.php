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

namespace Domain\Supplier\Model;

use Domain\Common\Model\Contact;
use Domain\Common\Model\Entities\FamilyLog;
use Domain\Common\Model\VO\EmailField;
use Domain\Common\Model\VO\NameField;
use Domain\Common\Model\VO\PhoneField;

final class Supplier extends Contact
{
    protected string $uuid;
    private FamilyLog $familyLog;
    private int $delayDelivery;
    private array $orderDays;
    private bool $active;

    public function __construct(
        SupplierUuid $uuid,
        NameField $name,
        string $address,
        string $zipCode,
        string $town,
        string $country,
        PhoneField $phone,
        PhoneField $facsimile,
        EmailField $email,
        string $contact,
        PhoneField $cellphone,
        FamilyLog $familyLog,
        int $delayDelivery,
        array $orderDays,
        bool $active = true
    ) {
        parent::__construct(
            $uuid,
            $name,
            $address,
            $zipCode,
            $town,
            $country,
            $phone,
            $facsimile,
            $email,
            $contact,
            $cellphone
        );
        $this->familyLog = $familyLog;
        $this->delayDelivery = $delayDelivery;
        $this->orderDays = $orderDays;
        $this->active = $active;
    }

    public static function create(
        SupplierUuid $uuid,
        NameField $name,
        string $address,
        string $zipCode,
        string $town,
        string $country,
        PhoneField $phone,
        PhoneField $facsimile,
        EmailField $email,
        string $contact,
        PhoneField $gsm,
        FamilyLog $familyLog,
        int $delayDelivery,
        array $orderDays,
        bool $active = true
    ): self {
        return new self(
            $uuid,
            $name,
            $address,
            $zipCode,
            $town,
            $country,
            $phone,
            $facsimile,
            $email,
            $contact,
            $gsm,
            $familyLog,
            $delayDelivery,
            $orderDays,
            $active
        );
    }

    public function renameSupplier(NameField $name): void
    {
        $this->name = $name->getValue();
        $this->slug = $name->slugify();
    }

    public function familyLog(): FamilyLog
    {
        return $this->familyLog;
    }

    public function setFamilyLog(FamilyLog $familyLog): void
    {
        $this->familyLog = $familyLog;
    }

    public function delayDelivery(): int
    {
        return $this->delayDelivery;
    }

    public function setDelayDelivery(int $delayDelivery): void
    {
        $this->delayDelivery = $delayDelivery;
    }

    public function getOrderDays(): array
    {
        return $this->orderDays;
    }

    public function setOrderDays(array $orderDays): void
    {
        $this->orderDays = $orderDays;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }
}
