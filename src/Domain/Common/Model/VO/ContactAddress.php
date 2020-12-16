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

namespace Domain\Common\Model\VO;

final class ContactAddress
{
    private string $address;
    private string $zipCode;
    private string $town;
    private string $country;

    public function __construct(string $address, string $zipCode, string $town, string $country)
    {
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->town = $town;
        $this->country = $country;
    }

    public static function fromString(string $stringAddress): self
    {
        \preg_match(
            '/([0-9-a-zA-Zéêèëùûü ]*)\n(\d{5}) ([0-9-a-zA-Zéêèëùûü ]*), ([0-9-a-zA-Zéêèëùûü ]*)/u',
            $stringAddress,
            $completeAddress
        );
        [$full, $address, $zipCode, $town, $country] = $completeAddress;

        return new self($address, $zipCode, $town, $country);
    }

    public static function fromArray(array $addressData): self
    {
        if ([$address, $zipcode, $town, $country] = $addressData) {
            return new self($address, $zipcode, $town, $country);
        }

        throw new \DomainException('The address data are not valid');
    }

    public function getValue(): string
    {
        return $this->address . "\n" . $this->zipCode . ' ' . $this->town . ', ' . $this->country;
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
}
