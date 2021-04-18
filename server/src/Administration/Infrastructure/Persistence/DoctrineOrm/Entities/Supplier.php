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

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="supplier")
 * @ORM\Entity(repositoryClass="Administration\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineSupplierRepository")
 */
class Supplier extends Contact
{
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $familyLog;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $delayDelivery;

    /**
     * @ORM\Column(type="array", nullable=false)
     */
    private array $orderDays;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $active;

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
        string $slug,
        string $familyLog,
        int $delayDelivery,
        array $orderDays,
        bool $active
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
            $cellphone,
            $slug
        );
        $this->familyLog = $familyLog;
        $this->delayDelivery = $delayDelivery;
        $this->orderDays = $orderDays;
        $this->active = $active;
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
