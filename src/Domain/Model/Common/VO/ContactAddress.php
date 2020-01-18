<?php

declare(strict_types=1);

namespace Domain\Model\Common\VO;

final class ContactAddress
{
    /**
     * @var string Address
     */
    protected $address;
    /**
     * @var string Zip code
     */
    protected $zipCode;

    /**
     * @var string Town
     */
    protected $town;

    /**
     * @var string Country
     */
    protected $country;

    /**
     * ContactAddress constructor.
     *
     * @param string $address
     * @param string $zipCode
     * @param string $town
     * @param string $country
     */
    public function __construct(string $address, string $zipCode, string $town, string $country)
    {
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->town = $town;
        $this->country = $country;
    }

    public static function fromString(string $address, string $zipCode, string $town, string $country): self
    {
        return new self($address, $zipCode, $town, $country);
    }

    public function getValue(): string
    {
        return $this->address."\n".$this->zipCode.' '.$this->town.', '.$this->country;
    }
}
