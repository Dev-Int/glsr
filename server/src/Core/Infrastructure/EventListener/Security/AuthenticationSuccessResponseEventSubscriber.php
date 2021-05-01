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

namespace Core\Infrastructure\EventListener\Security;

use Core\Infrastructure\Persistence\DoctrineOrm\Entities\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AuthenticationSuccessResponseEventSubscriber implements EventSubscriberInterface
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        $data['profile'] = \array_merge([
            'uuid' => $user->getUuid(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ], $user->getProfileInfos());

        $event->setData($data);
    }

    public static function getSubscribedEvents(): array
    {
        return ['lexik_jwt_authentication.on_authentication_success' => 'onAuthenticationSuccessResponse'];
    }
}
