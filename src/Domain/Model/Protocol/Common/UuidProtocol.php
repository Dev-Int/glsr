<?php

declare(strict_types=1);

/*
 * This file is part of the Tests package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Domain\Model\Protocol\Common;

use Domain\Model\Protocol\IdProtocol;

interface UuidProtocol extends IdProtocol
{
    /**
     * @return static
     */
    public static function fromUuid(object $uuid);

    /**
     * @return static
     */
    public static function fromString(string $uuid);
}
