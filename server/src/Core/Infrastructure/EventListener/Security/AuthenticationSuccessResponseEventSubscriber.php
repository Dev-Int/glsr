<?php

namespace Core\Infrastructure\EventListener\Security;

use Core\Domain\Model\User;
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

        $data['profile'] = array_merge([
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
