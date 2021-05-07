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

namespace Company\Application\Settings\DTO;

use Company\Domain\Model\VO\Currency;
use Company\Domain\Model\VO\Locale;
use Core\Domain\Common\Model\VO\ResourceUuid;

class OutputSettings
{
    private string $uuid;
    private string $locale;
    private string $currency;
    private string $symbol;

    public function __construct(ResourceUuid $uuid, Locale $locale, Currency $currency)
    {
        $this->uuid = $uuid->toString();
        $this->locale = $locale->toString();
        $this->currency = $currency->currency();
        $this->symbol = $currency->symbol();
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

    public function symbol(): string
    {
        return $this->symbol;
    }
}
