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

namespace User\Domain\Storage;

use User\Infrastructure\Doctrine\Entity\User;

interface ReadUser
{
    public function existsWithUsername(string $username): bool;

    public function existsWithEmail(string $email): bool;

    public function findOneByUuid(string $uuid): ?User;
}
