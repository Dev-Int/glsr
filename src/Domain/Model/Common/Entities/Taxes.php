<?php

declare(strict_types=1);

namespace Domain\Model\Common\Entities;

use NumberFormatter;

class Taxes
{
    /**
     * @var float
     */
    private $rate;

    /**
     * @var false|string
     */
    private $name;

    /**
     * Taxes constructor.
     *
     * @param float $rate
     */
    public function __construct(float $rate)
    {
        $fmtPercent = new NumberFormatter('fr_FR', NumberFormatter::PERCENT);
        $fmtPercent->setAttribute($fmtPercent::FRACTION_DIGITS, 2);

        $this->rate = $rate / 100;

        $fraction = explode('.', (string) $rate);
        if (strlen($fraction[1]) > 2) {
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
        preg_match('/^([0-9]*)(,([0-9]*?)) %$/', trim($name), $str);
        $float = $str[1].'.'.$str[3];

        return new self((float) $float);
    }

    final public function rate(): float
    {
        return $this->rate;
    }

    final public function name(): string
    {
        return $this->name;
    }
}
