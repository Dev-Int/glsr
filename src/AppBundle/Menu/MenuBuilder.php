<?php
/**
 * MenuBuilder KnpMenu.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    since 1.0.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * class MenuBuilder.
 *
 * @category   Menu
 */
class MenuBuilder extends ContainerAware
{
    public function buildMainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        
        $menu->addChild('manage', array('label' => 'menu.management'))
            ->setExtra('translation_domain', 'messages')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa fa-dashboard');
        
        $menu['manage']->addChild('suppliers', array(
            'label' => 'title',
            'route' => 'suppliers'
        ))
            ->setExtra('translation_domain', 'gs_suppliers')
            ->setAttribute('icon', 'fa fa-barcode');
 
        $menu['manage']->addChild('articles', array(
            'label' => 'title',
            'route' => 'articles'
        ))
            ->setExtra('translation_domain', 'gs_articles')
            ->setAttribute('icon', 'fa fa-shopping-basket');
 
        $menu['manage']->addChild('inventory', array(
            'label' => 'title',
            'route' => 'inventory'
        ))
            ->setExtra('translation_domain', 'gs_inventories')
            ->setAttribute('icon', 'fa fa-tasks');

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
                ->addChild('zonestorage', array(
                    'route' => 'admin_zonestorage',
                    'label' => 'gestock.settings.diverse.zonestorage'
                ))
                ->setAttribute('icon', 'glyphicon glyphicon-map-marker');

            $divers
                ->addChild('unitstorage', array(
                    'route' => 'admin_unitstorage',
                    'label' => 'gestock.settings.diverse.unitstorage'
                ))
                ->setAttribute('icon', 'fa fa-cubes');

            $divers
                ->addChild('tva', array(
                    'route' => 'rate',
                    'label' => 'gestock.settings.diverse.vat'
                ))
                ->setAttribute('icon', 'glyphicon glyphicon-piggy-bank');

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
