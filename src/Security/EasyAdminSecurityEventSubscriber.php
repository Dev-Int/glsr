<?php
namespace App\Security;

use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class EasyAdminSecurityEventSubscriber implements EventSubscriberInterface
{
    private $decisionManager;
    private $token;

    public function __construct(AccessDecisionManagerInterface $decisionManager, TokenStorageInterface $token)
    {
        $this->decisionManager = $decisionManager;
        $this->token = $token;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_LIST => ['isAuthorized'],
            EasyAdminEvents::PRE_EDIT => ['isAuthorized'],
            EasyAdminEvents::PRE_DELETE => ['isAuthorized'],
            EasyAdminEvents::PRE_NEW => ['isAuthorized'],
            EasyAdminEvents::PRE_SHOW => ['isAuthorized'],
        ];
    }

    public function isAuthorized(GenericEvent $event)
    {
        $entityConfig = $event['entity'];

        $action = $event->getArgument('request')->query->get('action');

        if (!array_key_exists('permissions', $entityConfig) ||
            !array_key_exists($action, $entityConfig['permissions'])
        ) {
            return;
        }

        $authorizedRoles = $entityConfig['permissions']['action'];

        if (!$this->decisionManager->decide(
            $this->token->/** @scrutinizer ignore-call */ getToken(),
            $authorizedRoles
        )) {
            throw new AccessDeniedException();
        }
    }
}
