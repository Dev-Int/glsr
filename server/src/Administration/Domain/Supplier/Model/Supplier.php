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

namespace Administration\Domain\Supplier\Model;

use Core\Domain\Common\Model\Contact;
use Core\Domain\Common\Model\Dependent\FamilyLog;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;

final class Supplier extends Contact
{
    protected string $uuid;
    private string $familyLog;
    private int $delayDelivery;
    private array $orderDays;
    private bool $active;

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
        $this->familyLog = $familyLog->path();
        $this->delayDelivery = $delayDelivery;
        $this->orderDays = $orderDays;
        $this->active = $active;
    }

    public static function create(
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

    public function familyLog(): string
    {
        return $this->familyLog;
    }

    public function reassignFamilyLog(FamilyLog $familyLog): void
    {
        $this->familyLog = $familyLog->path();
    }

    public function delayDelivery(): int
    {
        return $this->delayDelivery;
    }

    public function changeDelayDelivery(int $delayDelivery): void
    {
        $this->delayDelivery = $delayDelivery;
    }

    public function orderDays(): array
    {
        return $this->orderDays;
    }

    public function reaffectOrderDays(array $orderDays): void
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
