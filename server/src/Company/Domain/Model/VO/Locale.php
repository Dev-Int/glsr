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

final class Locale
{
    public const LOCALE = ['fr'];

    private string $locale;

    public function __construct(string $locale)
    {
        $this->locale = self::isLocale($locale);
    }

    public static function fromString(string $locale): self
    {
        return new self($locale);
    }

    public static function fromLocale(self $locale): string
    {
        return $locale->toString();
    }

    public function toString(): string
    {
        return $this->locale;
    }

    private static function isLocale(string $locale): string
    {
        if (!\in_array(\strtolower($locale), self::LOCALE, true)) {
            throw new InvalidLocale();
        }

        return \strtolower($locale);
    }
}
