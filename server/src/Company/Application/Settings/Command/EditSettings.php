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

namespace Company\Application\Settings\Command;

use Company\Domain\Model\VO\Currency;
use Company\Domain\Model\VO\Locale;
use Core\Domain\Common\Command\CommandInterface;
use Core\Domain\Common\Model\VO\ResourceUuid;

final class EditSettings implements CommandInterface
{
    public string $uuid;
    private string $locale;
    private string $currency;

    public function __construct(string $locale, string $currency)
    {
        $this->locale = $locale;
        $this->currency = $currency;
    }

    public function uuid(): ResourceUuid
    {
        return ResourceUuid::fromString($this->uuid);
    }

    public function locale(): Locale
    {
        return Locale::fromString($this->locale);
    }

    public function currency(): Currency
    {
        return Currency::fromString($this->currency);
    }
}
