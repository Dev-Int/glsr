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

namespace User\Infrastructure\Storage;

use User\Domain\Exception\UserNotFoundException;
use User\Domain\Model\User as UserModel;

class SaveUser implements \User\Domain\Storage\SaveUser
{
    private CreateUser $createUser;
    private UpdateUser $updateUser;

    public function __construct(CreateUser $createUser, UpdateUser $updateUser)
    {
        $this->createUser = $createUser;
        $this->updateUser = $updateUser;
    }

    public function save(UserModel $user): void
    {
        try {
            $this->updateUser->update($user);
        } catch (UserNotFoundException $userNotFoundException) {
            $this->createUser->create($user);
        }
    }
}
