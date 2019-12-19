<?php

declare(strict_types=1);

namespace Domain\Model\Common\VO;

use Domain\Model\Common\InvalidPhone;

final class PhoneField
{
    /**
     * @var string
     */
    private $phone;

    /**
     * PhoneField constructor.
     * @param string $phone
     */
    public function __construct(string $phone)
    {
        $phoneSanitized = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $phoneToCheck = str_replace("-", "", $phoneSanitized);
        if (10 > strlen($phoneToCheck) || strlen($phoneToCheck) > 14) {
            throw new InvalidPhone();
        }
        $this->phone = $phoneSanitized;
    }

    public static function fromString(string $phone): self
    {
        return new self($phone);
    }

    public function getValue(): string
    {
        return $this->phone;
    }
}
