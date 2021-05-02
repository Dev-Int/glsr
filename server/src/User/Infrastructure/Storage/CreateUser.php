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

use User\Domain\Exception\UserAlreadyExistException;
use User\Domain\Model\User as UserModel;
use User\Infrastructure\Doctrine\Entity\User;
use User\Infrastructure\Doctrine\Repository\UserRepository;

class CreateUser
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(UserModel $user): void
    {
        if ($this->userRepository->existWithUsername($user->username()->getValue())) {
            throw new UserAlreadyExistException();
        }

        $userEntity = User::fromModel($user);
        $this->userRepository->save($userEntity);
    }
}
