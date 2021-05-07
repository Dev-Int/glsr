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

namespace Company\Domain\Model\VO;

final class Currency
{
    public const CURRENCY = ['euro'];
    public const SYMBOL = ['€'];

    private string $currency;
    private string $symbol;

    public function __construct(string $currency)
    {
        $this->currency = self::isCurrency($currency);
        $this->symbol = self::isSymbol($this->currency);
    }

    public static function fromString(string $currency): self
    {
        return new self($currency);
    }

    public static function fromCurrency(self $currency): string
    {
        return $currency->toString();
    }

    public function getValue(): string
    {
        return $this->currency;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function symbol(): string
    {
        return $this->symbol;
    }

    private static function isCurrency(string $currency): string
    {
        if (!\in_array(\strtolower($currency), self::CURRENCY, true)) {
            throw new InvalidCurrency();
        }

        return \strtolower($currency);
    }

    private static function isSymbol(string $currency): string
    {
        return self::SYMBOL[\array_search($currency, self::CURRENCY, true)];
    }

    private function toString(): string
    {
        return $this->currency;
    }
}
