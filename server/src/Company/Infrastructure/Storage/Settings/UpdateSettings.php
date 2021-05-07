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
use Company\Infrastructure\Doctrine\Entity\Settings as SettingsEntity;
use Company\Infrastructure\Doctrine\Repository\SettingsRepository;

class UpdateSettings
{
    private SettingsRepository $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function update(Settings $settingsModel): void
    {
        /** @var SettingsEntity $settingsEntity */
        $settingsEntity = $this->settingsRepository->findOneByUuid($settingsModel->uuid());

        if (!$settingsEntity instanceof SettingsEntity) {
            throw new SettingsNotFoundException();
        }

        $settingsEntity->update($settingsEntity);

        $this->settingsRepository->flush();
    }
}
