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

namespace Administration\Infrastructure\Settings\Mapper;

use Administration\Application\Settings\ReadModel\Settings as SettingsReadModel;
use Administration\Domain\Settings\Model\Settings;
use Administration\Domain\Settings\Model\VO\Currency;
use Administration\Domain\Settings\Model\VO\Locale;
use Administration\Domain\Settings\Model\VO\SettingsUuid;

class SettingsModelMapper
{
    public function getReadModelFromArray(array $data): SettingsReadModel
    {
        $symbol = Currency::fromString($data['currency']);

        return new SettingsReadModel(
            $data['currency'],
            $data['locale'],
            $symbol->symbol(),
            $data['uuid']
        );
    }

    public function getDomainModelFromArray(array $data): Settings
    {
        return Settings::create(
            SettingsUuid::fromString($data['uuid']),
            Locale::fromString($data['locale']),
            Currency::fromString($data['currency'])
        );
    }

    public function getDataFromSettings(Settings $settings): array
    {
        return [
            'uuid' => $settings->uuid(),
            'locale' => $settings->locale(),
            'currency' => $settings->currency(),
        ];
    }
}
