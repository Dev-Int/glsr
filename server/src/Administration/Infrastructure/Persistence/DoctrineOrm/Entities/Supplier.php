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

namespace Administration\Infrastructure\Persistence\DoctrineOrm\Entities;

use Administration\Domain\Supplier\Model\Supplier as SupplierModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="supplier")
 * @ORM\Entity(repositoryClass="Administration\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineSupplierRepository")
 */
class Supplier extends Contact
{
    /**
     * @ORM\Column(type="string", name="family_log", nullable=false)
     */
    private string $familyLog;

    /**
     * @ORM\Column(type="integer", name="delay_delivery", nullable=false)
     */
    private int $delayDelivery;

    /**
     * @ORM\Column(type="array", name="order_days", nullable=false)
     */
    private array $orderDays;

    /**
     * @ORM\Column(type="boolean", name="active", nullable=false)
     */
    private bool $active;

    public function __construct(Contact $contact, string $familyLog, int $delayDelivery, array $orderDays, bool $active)
    {
        parent::__construct(
            $contact->uuid,
            $contact->companyName,
            $contact->address,
            $contact->zipCode,
            $contact->town,
            $contact->country,
            $contact->phone,
            $contact->facsimile,
            $contact->email,
            $contact->contactName,
            $contact->cellphone,
            $contact->slug
        );
        $this->familyLog = $familyLog;
        $this->delayDelivery = $delayDelivery;
        $this->orderDays = $orderDays;
        $this->active = $active;
    }

    public static function fromModel(SupplierModel $supplier): self
    {
        $contact = new Contact(
            $supplier->uuid(),
            $supplier->companyName(),
            $supplier->address(),
            $supplier->zipCode(),
            $supplier->town(),
            $supplier->country(),
            $supplier->phone(),
            $supplier->facsimile(),
            $supplier->email(),
            $supplier->contactName(),
            $supplier->cellphone(),
            $supplier->slug()
        );

        return new self(
            $contact,
            $supplier->familyLog(),
            $supplier->delayDelivery(),
            $supplier->orderDays(),
            $supplier->isActive()
        );
    }

    public function getFamilyLog(): string
    {
        return $this->familyLog;
    }

    public function setFamilyLog(string $familyLog): self
    {
        $this->familyLog = $familyLog;

        return $this;
    }

    public function getDelayDelivery(): int
    {
        return $this->delayDelivery;
    }

    public function setDelayDelivery(int $delayDelivery): self
    {
        $this->delayDelivery = $delayDelivery;

        return $this;
    }

    public function getOrderDays(): array
    {
        return $this->orderDays;
    }

    public function setOrderDays(array $orderDays): self
    {
        $this->orderDays = $orderDays;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
