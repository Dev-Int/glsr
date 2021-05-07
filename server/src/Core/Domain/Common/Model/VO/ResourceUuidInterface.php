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

namespace Core\Domain\Common\Model\VO;

interface ResourceUuidInterface
{
    public static function fromUuid(self $uuid): string;

    public static function generate(): ResourceUuid;

    public static function fromString(string $uuid): ResourceUuid;

    public function toString(): string;
}
