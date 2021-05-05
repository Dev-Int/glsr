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
use Company\Domain\Model\VO\Currency;
use Company\Domain\Model\VO\Locale;
use Company\Domain\Storage\Settings\ReadSettings as ReadSettingsDomain;
use Company\Domain\Storage\Settings\SettingsEntity;
use Company\Infrastructure\Doctrine\Repository\SettingsRepository;
use Core\Domain\Common\Model\VO\ResourceUuidInterface;

class ReadSettings implements ReadSettingsDomain
{
    private SettingsRepository $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function findAll(): array
    {
        return $this->settingsRepository->findAll();
    }

    public function findOneByUuid(ResourceUuidInterface $uuid): Settings
    {
        /** @var SettingsEntity $settingsEntity */
        $settingsEntity = $this->settingsRepository->findOneByUuid($uuid);

        return $this->trasformToModel($settingsEntity);
    }

    public function findByLocale(Locale $locale): Settings
    {
        $settingsEntity = $this->settingsRepository->findByLocale($locale);

        return $this->trasformToModel($settingsEntity);
    }

    public function save(SettingsEntity $settings): void
    {
        $this->settingsRepository->save($settings);
    }

    public function remove(SettingsEntity $settings): void
    {
        $this->settingsRepository->remove($settings);
    }

    public function findByCurrency(Currency $currency): Settings
    {
        $settingsEntity = $this->settingsRepository->findByCurrency($currency);

        return $this->trasformToModel($settingsEntity);
    }

    public function settingsExists(): bool
    {
        return $this->settingsRepository->settingsExists();
    }

    public function findDefaultSettings(): Settings
    {
        $settingsEntity = $this->settingsRepository->findOne();

        return $this->trasformToModel($settingsEntity);
    }

    private function trasformToModel(?SettingsEntity $settingsEntity): Settings
    {
        if (!$settingsEntity instanceof SettingsEntity) {
            throw new SettingsNotFoundException();
        }

        return $settingsEntity->toModel();
    }
}
