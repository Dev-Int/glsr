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

namespace Administration\Domain\Protocol\Repository;

use Administration\Domain\User\Model\User;

interface UserRepositoryProtocol
{
    public function add(User $user): void;

    public function remove(User $user): void;

    public function findOneByUuid(string $uuid): ?User;

    public function existWithUsername(string $username): bool;

    public function existWithEmail(string $email): bool;
}
