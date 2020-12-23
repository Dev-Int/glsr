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

namespace Administration\Domain\User\Command;

use Core\Domain\Protocol\Common\Command\CommandProtocol;

final class DeleteUser implements CommandProtocol
{
    private string $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }
}
