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

use Company\Domain\Exception\SettingsAlreadyExistException;
use Company\Domain\Model\Settings;
use Company\Infrastructure\Doctrine\Entity\Settings as SettingsEntity;
use Company\Infrastructure\Doctrine\Repository\SettingsRepository;

class CreateSettings
{
    private SettingsRepository $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function create(Settings $settings): void
    {
        if ($this->settingsRepository->settingsExists()) {
            throw new SettingsAlreadyExistException();
        }

        $settingsEntity = SettingsEntity::fromModel($settings);
        $this->settingsRepository->save($settingsEntity);
    }
}
