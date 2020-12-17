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

namespace Core\Domain\Common\Model\VO;

use Core\Domain\Common\Model\Exception\InvalidPhone;

final class PhoneField
{
    private string $phone;

    public function __construct(string $phone)
    {
        if (false === \filter_var($phone, \FILTER_SANITIZE_NUMBER_INT)) {
            throw new InvalidPhone();
        }

        $phoneSanitized = \filter_var($phone, \FILTER_SANITIZE_NUMBER_INT);
        $phoneToCheck = \str_replace('-', '', $phoneSanitized);

        if (10 > \strlen($phoneToCheck) || \strlen($phoneToCheck) > 14) {
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
