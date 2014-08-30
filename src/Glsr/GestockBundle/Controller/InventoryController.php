<?php
/**
 * controller de l'entité Inventory
 * 
 * PHP Version 5
 * 
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version   GIT: a4408b1f9fc87a1f93911d80e8421fef1bd96cab
 * @link      https://github.com/GLSR/glsr
 */

namespace Glsr\GestockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * class InventoryController
 * 
 * @category   Controller
 * @package    Gestock
 * @subpackage Inventory
 */
class InventoryController extends Controller
{
    /**
     * indexAction affiche la page d'accueil du Bundle
     * 
     * @return Render
     */
    public function indexAction()
    {
        return $this->render('GlsrGestockBundle:Gestock/Inventory:index.html.twig');
    }
}
