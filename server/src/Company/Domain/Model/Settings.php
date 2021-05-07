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

namespace Company\Domain\Model;

use Company\Domain\Model\VO\Currency;
use Company\Domain\Model\VO\Locale;
use Core\Domain\Common\Model\VO\ResourceUuid;

class Settings
{
    private ResourceUuid $uuid;
    private Locale $locale;
    private Currency $currency;

    private function __construct(ResourceUuid $uuid, Locale $locale, Currency $currency)
    {
        $this->uuid = $uuid;
        $this->locale = $locale;
        $this->currency = $currency;
    }

    public static function create(ResourceUuid $uuid, Locale $locale, Currency $currency): self
    {
        return new self($uuid, $locale, $currency);
    }

    public function uuid(): ResourceUuid
    {
        return $this->uuid;
    }

    public function locale(): Locale
    {
        return $this->locale;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }
}
