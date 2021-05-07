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

namespace User\Application\Factory;

use Core\Domain\Common\Command\CommandInterface;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\ResourceUuid;
use User\Domain\Model\User;
use User\Domain\Model\VO\Password;

class CreateUser
{
    public function createUser(CommandInterface $commandUser): User
    {
        $userUuid = null === $commandUser->uuid() ? ResourceUuid::generate() : ResourceUuid::fromString(
            $commandUser->uuid()
        );

        return User::create(
            $userUuid,
            NameField::fromString($commandUser->username()),
            EmailField::fromString($commandUser->email()),
            Password::fromString($commandUser->password()),
            $commandUser->roles()
        );
    }
}
