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

namespace Company\Domain\Storage\Settings;

use Company\Domain\Model\Settings;
use Company\Domain\Model\VO\Currency;
use Company\Domain\Model\VO\Locale;
use Core\Domain\Common\Model\VO\ResourceUuid;

interface ReadSettings
{
    public function findOneByUuid(ResourceUuid $uuid): Settings;

    public function findByLocale(Locale $locale): Settings;

    public function save(SettingsEntity $settings): void;

    public function remove(SettingsEntity $settings): void;

    public function findByCurrency(Currency $currency): Settings;

    public function settingsExists(): bool;

    public function findDefaultSettings(): Settings;

    public function findAll(): array;
}
