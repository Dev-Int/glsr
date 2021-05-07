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

namespace Company\Application\Settings\Factory;

use Company\Domain\Model\Settings;
use Core\Domain\Common\Command\CommandInterface;

class CreateSettings
{
    public function create(CommandInterface $command): Settings
    {
        return Settings::create(
            $command->uuid(),
            $command->locale(),
            $command->currency()
        );
    }
}
