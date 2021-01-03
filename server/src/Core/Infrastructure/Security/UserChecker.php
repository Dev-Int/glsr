<?php

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
