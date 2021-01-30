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
use Administration\Domain\Settings\Command\DeleteSettings;
use Core\Domain\Protocol\Common\Command\CommandHandlerProtocol;

class DeleteSettingsHandler implements CommandHandlerProtocol
{
    private SettingsRepositoryProtocol $repository;

    public function __construct(SettingsRepositoryProtocol $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteSettings $command): void
    {
        $settings = $this->repository->findOneByUuid($command->uuid());
        if (null === $settings) {
            throw new \DomainException('Settings provided does not exist!');
        }

        $this->repository->remove($settings);
    }
}