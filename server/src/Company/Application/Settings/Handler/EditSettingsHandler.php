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

namespace Company\Application\Settings\Handler;

use Company\Application\Settings\Command\EditSettings;
use Company\Application\Settings\Factory\CreateSettings;
use Company\Domain\Storage\Settings\SaveSettings;
use Core\Domain\Common\Command\CommandHandlerInterface;

class EditSettingsHandler implements CommandHandlerInterface
{
    private SaveSettings $saveSettings;
    private CreateSettings $createSettings;

    public function __construct(
        SaveSettings $saveSettings,
        CreateSettings $createSettings
    ) {
        $this->saveSettings = $saveSettings;
        $this->createSettings = $createSettings;
    }

    public function __invoke(EditSettings $command): void
    {
        $this->saveSettings->save(
            $this->createSettings->create($command)
        );
    }
}
