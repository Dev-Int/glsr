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

use Company\Domain\Model\Settings as SettingsModel;

interface SettingsEntity
{
    public static function fromModel(SettingsModel $settingsModel): self;

    public function toModel(): SettingsModel;

    public function getUuid(): string;

    public function getLocale(): string;

    public function getCurrency(): string;

    public function update(self $settingsEntity): self;
}
