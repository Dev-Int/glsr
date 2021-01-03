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

namespace Core\Infrastructure\Security;

use Core\Domain\Model\User;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }
        // if ($user->isDeleted()) {
        //     throw new CustomUserMessageAuthenticationException('Your user account is not enabled!');
        // }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }
        // if ($user->isDeleted()) {
        //     throw new CustomUserMessageAuthenticationException('Your user account is not enabled!');
        // }
    }
}
