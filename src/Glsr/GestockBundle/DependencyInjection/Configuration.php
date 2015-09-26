<?php

/**
 * Configuration de l'injection des dépendences.
 *
 * @author     Quétier Laurent
 * <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php
 * GNU Public License
 *
 * @version    GIT: 66c30ad5658ae2ccc5f74e6258fa4716d852caf9
 */
namespace Glsr\GestockBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates
 * and merges configuration from your app/config files.
 *
 * @category   DependencyInjection

 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 * #cookbook-bundles-extension-config-class
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
