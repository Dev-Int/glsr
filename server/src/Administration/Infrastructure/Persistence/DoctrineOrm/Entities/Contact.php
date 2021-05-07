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

use Core\Infrastructure\Doctrine\Entity\ResourceUuid as ResourceUuidTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class Contact
{
    use ResourceUuidTrait;

    /**
     * @ORM\Column(type="string", name="company_name", unique=true, nullable=false)
     */
    protected string $companyName;

    /**
     * @ORM\Column(type="string", name="address", nullable=false)
     */
    protected string $address;

    /**
     * @ORM\Column(type="string", length=5, name="zip_code", nullable=false)
     */
    protected string $zipCode;

    /**
     * @ORM\Column(type="string", name="town", nullable=false)
     */
    protected string $town;

    /**
     * @ORM\Column(type="string", name="country", nullable=false)
     */
    protected string $country;

    /**
     * @ORM\Column(type="string", length=14, name="phone", nullable=false)
     */
    protected string $phone;

    /**
     * @ORM\Column(type="string", length=14, name="facsimile", nullable=true)
     */
    protected string $facsimile;

    /**
     * @ORM\Column(type="string", name="email", nullable=false)
     */
    protected string $email;

    /**
     * @ORM\Column(type="string", name="contact_name", nullable=false)
     */
    protected string $contactName;

    /**
     * @ORM\Column(type="string", length=14, name="cellphone", nullable=false)
     */
    protected string $cellphone;

    /**
     * @ORM\Column(type="string", name="slug", unique=true, nullable=false)
     */
    protected string $slug;

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
        string $contactName,
        string $cellphone,
        string $slug
    ) {
        $this->uuid = $uuid;
        $this->companyName = $companyName;
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->town = $town;
        $this->country = $country;
        $this->phone = $phone;
        $this->facsimile = $facsimile;
        $this->email = $email;
        $this->contactName = $contactName;
        $this->cellphone = $cellphone;
        $this->slug = $slug;
    }

    public static function create(
        string $uuid,
        string $companyName,
        string $address,
        string $zipCode,
        string $town,
        string $country,
        string $phone,
        string $facsimile,
        string $email,
        string $contactName,
        string $cellphone,
        string $slug
    ): self {
        return new self(
            $uuid,
            $companyName,
            $address,
            $zipCode,
            $town,
            $country,
            $phone,
            $facsimile,
            $email,
            $contactName,
            $cellphone,
            $slug
        );
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getTown(): string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFacsimile(): string
    {
        return $this->facsimile;
    }

    public function setFacsimile(string $facsimile): self
    {
        $this->facsimile = $facsimile;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContactName(): string
    {
        return $this->contactName;
    }

    public function setContactName(string $contactName): self
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getCellphone(): string
    {
        return $this->cellphone;
    }

    public function setCellphone(string $cellphone): self
    {
        $this->cellphone = $cellphone;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
