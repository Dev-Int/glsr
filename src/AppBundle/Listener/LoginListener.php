<?php
/**
 * LoginListener EventListener.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Listener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

/**
 * LoginListener EventListener.
 *
 * @category Listener
 */
class LoginListener implements EventSubscriberInterface
{
    protected $userManager;
    
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }
     
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::SECURITY_IMPLICIT_LOGIN => 'onImplicitLogin',
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',
        );
    }
 
    protected function updateUser($user)
    {
        if (!$user->getLoginCount()) {
            $user->setFirstLogin(new \DateTime());
        }
         
        $user->setLoginCount((int) $user->getLoginCount() + 1);
         
        $this->userManager->updateUser($user);
    }
     
    public function onImplicitLogin(UserEvent $event)
    {
        $this->updateUser($event->getUser());
    }
     
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $this->updateUser($user);
    }
}
