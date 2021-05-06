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

use Core\Domain\Common\Model\VO\ResourceUuid;
use User\Domain\Exception\UserNotFoundException;
use User\Domain\Storage\RemoveUser as RemoveUserDomain;
use User\Infrastructure\Doctrine\Entity\User;
use User\Infrastructure\Doctrine\Repository\UserRepository;

class RemoveUser implements RemoveUserDomain
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function remove(string $uuid): void
    {
        $user = $this->userRepository->findOneByUuid(ResourceUuid::fromString($uuid)->__toString());

        if (!$user instanceof User) {
            throw new UserNotFoundException();
        }

        $this->userRepository->remove($user);
    }
}
