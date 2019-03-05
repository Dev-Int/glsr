<?php
/**
 * MenuBuilder KnpMenu.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @see https://github.com/Dev-Int/glsr
 */

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * class MenuBuilder.
 *
 * @category Menu
 */
class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Factory.
     *
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * TokenStorage.
     *
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * AuthorizationChecker.
     *
     * @var AuthorizationChecker
     */
    protected $authorizationChecker;

    /**
     * Constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param AuthorizationChecker  $authorizationChecker
     * @param FactoryInterface      $factory
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        AuthorizationChecker $authorizationChecker,
        FactoryInterface $factory
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->factory = $factory;
    }

    public function buildOrderMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild('order', array('label' => 'menu.order'))
            ->setExtra('translation_domain', 'messages')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa fa-shopping-cart');

        $menu['order']->addChild('orders', ['label' => 'title_short', 'route' => 'orders'])
            ->setExtra('translation_domain', 'gs_orders')
            ->setAttribute('icon', 'fa fa-shopping-cart');

        $menu['order']->addChild('deliveries', ['label' => 'title_short', 'route' => 'deliveries'])
            ->setExtra('translation_domain', 'gs_deliveries')
            ->setAttribute('icon', 'fa fa-truck');

        $menu['order']->addChild('invoices', ['label' => 'title_short', 'route' => 'invoices'])
            ->setExtra('translation_domain', 'gs_invoices')
            ->setAttribute('icon', 'fa fa-calculator');

        return $menu;
    }

    public function buildStockMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild('stock', array('label' => 'menu.stock'))
            ->setExtra('translation_domain', 'messages')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa fa-dashboard');

        $menu['stock']->addChild('inventory', ['label' => 'title_short', 'route' => 'inventory'])
            ->setExtra('translation_domain', 'gs_inventories')
            ->setAttribute('icon', 'fa fa-tasks');

        $menu['stock']->addChild('articles', ['label' => 'menu.articles', 'route' => 'article'])
            ->setExtra('translation_domain', 'gs_articles')
            ->setAttribute('icon', 'fa fa-list');

        return $menu;
    }

    public function buildConfigMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild('config', array('label' => 'menu.configuration'))
            ->setExtra('translation_domain', 'messages')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa fa-cog');

        $menu['config']->addChild('company', ['route' => 'company', 'label' => 'gestock.settings.company.title'])
            ->setExtra('translation_domain', 'messages')
            ->setAttribute('icon', 'glyphicon glyphicon-tower');

        $menu['config']
            ->addChild('applcation', ['route' => 'application', 'label' => 'gestock.settings.settings.title'])
            ->setExtra('translation_domain', 'messages')
            ->setAttribute('icon', 'glyphicon glyphicon-wrench')
            ->setAttribute('divider_append', true);

        $menu['config']->addChild('suppliers', ['label' => 'title', 'route' => 'supplier'])
            ->setExtra('translation_domain', 'gs_suppliers')
            ->setAttribute('icon', 'fa fa-barcode');

        $menu['config']->addChild('article', ['label' => 'title', 'route' => 'article'])
            ->setExtra('translation_domain', 'gs_articles')
            ->setAttribute('icon', 'fa fa-shopping-basket');

        $divers = $menu['config']->addChild('divers', ['label' => 'gestock.settings.diverse.title'])
            ->setExtra('translation_domain', 'messages')
            ->setAttribute('dropdown', true)
            ->setAttribute('class', 'dropdown-submenu')
            ->setAttribute('icon', 'glyphicon glyphicon-info-sign');

        $divers->addChild('familylog', ['route' => 'familylog', 'label' => 'gestock.settings.diverse.familylog'])
            ->setAttribute('icon', 'glyphicon glyphicon-tag');

        $divers
            ->addChild('zonestorage', ['route' => 'zonestorage', 'label' => 'gestock.settings.diverse.zonestorage'])
            ->setAttribute('icon', 'glyphicon glyphicon-map-marker');

        $divers
            ->addChild('unit', ['route' => 'unit', 'label' => 'gestock.settings.diverse.unit'])
            ->setAttribute('icon', 'fa fa-cubes');

        $divers->addChild('tva', ['route' => 'tva', 'label' => 'gestock.settings.diverse.vat'])
            ->setAttribute('icon', 'glyphicon glyphicon-piggy-bank');

        $divers->addChild('material', ['route' => 'material', 'label' => 'menu.material'])
            ->setAttribute('icon', 'fa fa-pie-chart');

        return $menu;
    }

    /*
    public function buildUserMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            // Menu Administration

            $menu->addChild('entities', ['label' => 'menu.staf'])
                ->setExtra('translation_domain', 'messages')
                ->setAttribute('dropdown', true)
                ->setAttribute('class', 'multi-level')
                ->setAttribute('icon', 'glyphicon glyphicon-cog');

            $menu['entities']->addChild('users', ['route' => 'user', 'label' => 'menu.users'])
                ->setAttribute('icon', 'glyphicon glyphicon-user');

            $menu['entities']->addChild('groups', ['route' => 'group', 'label' => 'menu.groups'])
                ->setAttribute('icon', 'fa fa-users');
        }
        // Menu Profile

        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $menu->addChild('profile', array(
                        'label' => $this->tokenStorage->getToken()->getUser()->getUsername(), ))
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'fa fa-user');

            $menu['profile']->addChild('layout.logout', ['route' => 'fos_user_security_logout'])
                ->setExtra('translation_domain', 'FOSUserBundle')
                ->setAttribute('icon', 'fa fa-unlink');
        } else {
            $menu->addChild('profile', ['label' => 'menu.administration'])
                ->setExtra('translation_domain', 'messages')
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'fa fa-user');
        }
        $menu['profile']->addChild('menu.other_login', ['route' => 'fos_user_security_login'])
            ->setAttribute('icon', 'fa fa-link');

        return $menu;
    }
    */
}
