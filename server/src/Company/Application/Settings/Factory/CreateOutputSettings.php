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

use Company\Application\Settings\DTO\OutputSettings;
use Company\Domain\Model\Settings;

class CreateOutputSettings
{
    public function create(Settings $settings): OutputSettings
    {
        return new OutputSettings(
            $settings->uuid(),
            $settings->locale(),
            $settings->currency()
        );
    }
}
