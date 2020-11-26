<?php

declare(strict_types=1);

/*
 * This file is part of the Tests package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Domain\Model\Common\Entities;

use NumberFormatter;

final class Taxes
{
    private float $rate;
    private ?string $name;

    public function __construct(float $rate)
    {
        $fmtPercent = new NumberFormatter('fr_FR', NumberFormatter::PERCENT);
        $fmtPercent->setAttribute($fmtPercent::FRACTION_DIGITS, 2);

        $this->rate = $rate / 100;

        $fraction = \explode('.', (string) $rate);
        if (\strlen($fraction[1]) > 2) {
            $this->rate = $rate;
        }

        $this->name = $fmtPercent->format($this->rate);
    }

    public static function fromFloat(float $rate): self
    {
        return new self($rate);
    }

    public static function fromPercent(string $name): self
    {
        \preg_match('/^(\d*)(,(\d*?)) %$/u', \trim($name), $str);
        $float = $str[1] . '.' . $str[3];

        return new self((float) $float);
    }

    public function rate(): float
    {
        return $this->rate;
    }

    public function name(): string
    {
        return $this->name;
    }
}
