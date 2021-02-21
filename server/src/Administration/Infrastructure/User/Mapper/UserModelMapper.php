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

namespace Administration\Infrastructure\User\Mapper;

use Administration\Application\User\ReadModel\User as UserReadModel;
use Administration\Domain\User\Model\User;

class UserModelMapper
{
    public function getReadModelFromArray(array $data): UserReadModel
    {
        return new UserReadModel(
            $data['uuid'],
            $data['username'],
            $data['email'],
            \explode(',', $data['roles']),
            null,
        );
    }

    public function getDataFromUser(User $user): array
    {
        return [
            'uuid' => $user->uuid()->toString(),
            'username' => $user->username(),
            'email' => $user->email()->getValue(),
            'password' => $user->password(),
            'roles' => \implode(',', $user->roles()),
        ];
    }
}
