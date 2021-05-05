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

namespace Company\Application\Settings\Query;

use Company\Domain\Model\VO\Currency;
use Company\Domain\Model\VO\Locale;
use Core\Domain\Common\Query\QueryInterface;

final class GetSettings implements QueryInterface
{
    private ?string $currency = null;
    private ?string $locale = null;

    public function __construct(?string $setting = null)
    {
        if (null !== $setting && \in_array($setting, Locale::LOCALE, true)) {
            $this->currency = $setting;
        }
        if (null !== $setting && \in_array($setting, Currency::CURRENCY, true)) {
            $this->locale = $setting;
        }
    }

    public function currency(): ?string
    {
        return $this->currency;
    }

    public function locale(): ?string
    {
        return $this->locale;
    }
}
