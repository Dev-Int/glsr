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

namespace Administration\Application\Settings\ReadModel;

class Settings
{
    public string $currency;
    public string $locale;
    public ?string $uuid;
    public ?string $symbol;

    public function __construct(string $currency, string $locale, ?string $symbol = null, ?string $uuid = null)
    {
        $this->currency = $currency;
        $this->locale = $locale;
        $this->symbol = $symbol;
        $this->uuid = $uuid;
    }
}
