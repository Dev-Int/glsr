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

use Administration\Domain\Protocol\Repository\SettingsRepositoryProtocol;
use Administration\Domain\Settings\Command\ConfigureSettings;
use Administration\Domain\Settings\Model\Settings;
use Administration\Domain\Settings\Model\VO\SettingsUuid;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;

class ConfigureSettingsHandler implements CommandHandlerProtocol
{
    private SettingsRepositoryProtocol $repository;

    public function __construct(SettingsRepositoryProtocol $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ConfigureSettings $command): void
    {
        if ($this->repository->exists()) {
            throw new \DomainException('The application is already configured');
        }

        $settings = Settings::create(
            SettingsUuid::generate(),
            $command->locale(),
            $command->currency()
        );

        $this->repository->add($settings);
    }
}
