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

namespace Company\Infrastructure\Storage\Settings;

use Company\Domain\Exception\SettingsNotFoundException;
use Company\Domain\Model\Settings;
use Company\Domain\Storage\Settings\SaveSettings as SaveSettingsInterface;

class SaveSettings implements SaveSettingsInterface
{
    private UpdateSettings $updateSettings;
    private CreateSettings $createSettings;

    public function __construct(
        UpdateSettings $updateSettings,
        CreateSettings $createSettings
    ) {
        $this->updateSettings = $updateSettings;
        $this->createSettings = $createSettings;
    }

    public function save(Settings $settings): void
    {
        try {
            $this->updateSettings->update($settings);
        } catch (SettingsNotFoundException $settingsNotFoundException) {
            $this->createSettings->create($settings);
        }
    }
}
