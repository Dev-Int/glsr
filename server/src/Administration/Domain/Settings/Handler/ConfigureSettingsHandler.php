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

namespace Administration\Domain\Settings\Handler;

use Administration\Domain\Settings\Command\ConfigureSettings;
use Administration\Domain\Settings\Model\Settings;
use Administration\Domain\Settings\Model\VO\SettingsUuid;
use Administration\Infrastructure\Persistence\DoctrineOrm\Entities\Settings as SettingsEntity;
use Administration\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineSettingsRepository;
use Core\Domain\Protocol\Common\Command\CommandHandlerInterface;

class ConfigureSettingsHandler implements CommandHandlerInterface
{
    private DoctrineSettingsRepository $repository;

    public function __construct(DoctrineSettingsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ConfigureSettings $command): void
    {
        if ($this->repository->settingsExist()) {
            throw new \DomainException('The application is already configured');
        }

        $settings = Settings::create(
            SettingsUuid::generate(),
            $command->locale(),
            $command->currency()
        );

        $this->repository->save(SettingsEntity::fromModel($settings));
    }
}
