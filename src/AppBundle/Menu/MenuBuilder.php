<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MenuBuilder extends ContainerAware
{
    public function buildMainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
 
        return $menu;
    }
 
    public function buildUserMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
 
        $context = $this->container->get('security.context');
        if ($context->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            /*
             *  Menu Administration
             */
            $menu->addChild('entities', array('label' => 'menu.configuration'))
                ->setExtra('translation_domain', 'messages')
                ->setAttribute('dropdown', true)
                ->setAttribute('class', 'multi-level')
                ->setAttribute('icon', 'glyphicon glyphicon-cog');

            $menu['entities']
                ->addChild('company', array(
                    'route' => 'admin_company',
                    'label' => 'gestock.settings.company.title'
                ))
                ->setExtra('translation_domain', 'messages')
                ->setAttribute('icon', 'glyphicon glyphicon-tower');

            $menu['entities']
                ->addChild('applcation', array(
                    'route' => 'admin_application',
                    'label' => 'gestock.settings.application.title'
                ))
                ->setExtra('translation_domain', 'messages')
                ->setAttribute('icon', 'glyphicon glyphicon-wrench');

            $divers = $menu['entities']
                ->addChild('divers', array('label' => 'gestock.settings.diverse.title'))
                ->setExtra('translation_domain', 'messages')
                ->setAttribute('dropdown', true)
                ->setAttribute('class', 'dropdown-submenu')
                ->setAttribute('icon', 'glyphicon glyphicon-info-sign');
            
            $divers
                ->addChild('familylog', array(
                    'route' => 'admin_familylog',
                    'label' => 'gestock.settings.diverse.familylog'
                ))
                ->setAttribute('icon', 'glyphicon glyphicon-tag');

            $divers
                ->addChild('subfamilylog', array(
                    'route' => 'admin_subfamilylog',
                    'label' => 'gestock.settings.diverse.subfamilylog'
                ))
                ->setAttribute('icon', 'glyphicon glyphicon-tags');

            $divers
                ->addChild('zonestorage', array(
                    'route' => 'admin_zonestorage',
                    'label' => 'gestock.settings.diverse.zonestorage'
                ))
                ->setAttribute('icon', 'glyphicon glyphicon-globe');

            $menu['entities']
                ->addChild('divider')
                ->setAttribute('class', 'divider');

            $menu['entities']
                ->addChild('users', array(
                    'route' => 'admin_users',
                    'label' => 'menu.users'))
                ->setAttribute('icon', 'glyphicon glyphicon-user');

            $menu['entities']
                ->addChild('groups', array(
                    'route' => 'admin_groups',
                    'label' => 'menu.groups'))
                ->setAttribute('icon', 'fa fa-users');
        }
        /*
         *  Menu Profile
         */
        if ($context->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $menu->addChild('profile', array(
                        'label' => $context->getToken()->getUser()->getUsername()))
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'fa fa-user');
            
            $menu['profile']->addChild('layout.logout', array('route' => 'fos_user_security_logout'))
                ->setExtra('translation_domain', 'FOSUserBundle')
                ->setAttribute('icon', 'fa fa-unlink');
        } else {
            $menu->addChild('profile', array(
                        'label' => 'menu.administration'
                ))
                ->setExtra('translation_domain', 'messages')
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'fa fa-user');
        }
        $menu['profile']->addChild('menu.other_login', array('route' => 'fos_user_security_login'))
            ->setAttribute('icon', 'fa fa-link');
 
        return $menu;
    }
 
}