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

namespace Administration\Domain\Settings\Model;

use Administration\Domain\Settings\Model\VO\Currency;
use Administration\Domain\Settings\Model\VO\Locale;
use Administration\Domain\Settings\Model\VO\SettingsUuid;

final class Settings
{
    private string $uuid;
    private string $locale;
    private string $currency;

    public function __construct(SettingsUuid $uuid, Locale $locale, Currency $currency)
    {
        $this->uuid = $uuid->toString();
        $this->locale = $locale->getValue();
        $this->currency = $currency->getValue();
    }

    public static function create(SettingsUuid $uuid, Locale $locale, Currency $currency): self
    {
        return new self($uuid, $locale, $currency);
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function locale(): string
    {
        return $this->locale;
    }

    public function currency(): string
    {
        return $this->currency;
    }
}
