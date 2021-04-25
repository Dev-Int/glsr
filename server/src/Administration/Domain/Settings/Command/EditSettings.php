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

namespace Administration\Domain\Settings\Command;

use Administration\Domain\Settings\Model\VO\Currency;
use Administration\Domain\Settings\Model\VO\Locale;
use Administration\Domain\Settings\Model\VO\SettingsUuid;
use Core\Domain\Protocol\Common\Command\CommandInterface;

final class EditSettings implements CommandInterface
{
    private string $uuid;
    private Locale $locale;
    private Currency $currency;

    public function __construct(SettingsUuid $uuid, Locale $locale, Currency $currency)
    {
        $this->uuid = $uuid->toString();
        $this->locale = $locale;
        $this->currency = $currency;
    }

    public function uuid(): string
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
