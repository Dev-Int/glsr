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
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * class MenuBuilder.
 *
 * @category   Menu
 */
class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;
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
            'route' => 'supplier'
        ))
            ->setExtra('translation_domain', 'gs_suppliers')
            ->setAttribute('icon', 'fa fa-barcode');
 
        $menu['manage']->addChild('article', array(
            'label' => 'title',
            'route' => 'article'
        ))
            ->setExtra('translation_domain', 'gs_articles')
            ->setAttribute('icon', 'fa fa-shopping-basket');
 
        $menu['manage']->addChild('inventory', array(
            'label' => 'title_short',
            'route' => 'inventory'
        ))
            ->setExtra('translation_domain', 'gs_inventories')
            ->setAttribute('icon', 'fa fa-tasks');
 
        $menu['manage']->addChild('orders', array(
            'label' => 'title_short',
            'route' => 'orders'
        ))
            ->setExtra('translation_domain', 'gs_orders')
            ->setAttribute('icon', 'fa fa-shopping-cart');

        return $menu;
    }
 
    public function buildUserMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
 
        $context = $this->container->get('security.authorization_checker');
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
                    'route' => 'company',
                    'label' => 'gestock.settings.company.title'
                ))
                ->setExtra('translation_domain', 'messages')
                ->setAttribute('icon', 'glyphicon glyphicon-tower');

            $menu['entities']
                ->addChild('applcation', array(
                    'route' => 'application',
                    'label' => 'gestock.settings.settings.title'
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
                    'route' => 'familylog',
                    'label' => 'gestock.settings.diverse.familylog'
                ))
                ->setAttribute('icon', 'glyphicon glyphicon-tag');

            $divers
                ->addChild('zonestorage', array(
                    'route' => 'zonestorage',
                    'label' => 'gestock.settings.diverse.zonestorage'
                ))
                ->setAttribute('icon', 'glyphicon glyphicon-map-marker');

            $divers
                ->addChild('unitstorage', array(
                    'route' => 'unitstorage',
                    'label' => 'gestock.settings.diverse.unitstorage'
                ))
                ->setAttribute('icon', 'fa fa-cubes');

            $divers
                ->addChild('tva', array(
                    'route' => 'tva',
                    'label' => 'gestock.settings.diverse.vat'
                ))
                ->setAttribute('icon', 'glyphicon glyphicon-piggy-bank');

            $menu['entities']
                ->addChild('divider')
                ->setAttribute('class', 'divider');

            $menu['entities']
                ->addChild('users', array(
                    'route' => 'user',
                    'label' => 'menu.users'))
                ->setAttribute('icon', 'glyphicon glyphicon-user');

            $menu['entities']
                ->addChild('groups', array(
                    'route' => 'group',
                    'label' => 'menu.groups'))
                ->setAttribute('icon', 'fa fa-users');
        }
        /*
         *  Menu Profile
         */
        $context2 = $this->container->get('security.token_storage');
        if ($context->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $menu->addChild('profile', array(
                        'label' => $context2->getToken()->getUser()->getUsername()))
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
