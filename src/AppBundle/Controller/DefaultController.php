<?php
/**
 * DefaultController controller de l'application GLSR.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version   0.1.0
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * class DefaultController.
 *
 * @category Controller
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
    private $entities;
    
    public function __construct()
    {
        // Tableau des entitées
        $this->entities = array(
            'AppBundle:User',
            'AppBundle:Company',
            'AppBundle:Settings',
            'AppBundle:FamilyLog',
            'AppBundle:SubFamilyLog',
            'AppBundle:ZoneStorage',
            'AppBundle:UnitStorage',
            'AppBundle:Tva',
            'AppBundle:Supplier',
            'AppBundle:Article',
            'AppBundle:Settings');

    }
    /**
     * @Route("/", name="_home")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        /**
         * Test d'installation
         */
//        $url = $this->testEntities();
        if (empty($url)) {
            $url = $this->render('default/index.html.twig');
        } else {
            $url = $this->redirect($this->generateUrl($url));
        }
        // replace this example code with whatever you need
        return $url;
    }

    /**
     * Test des entités
     *
     * @return array
     */
    private function testEntities()
    {
        $url = null;
        $etm = $this->getDoctrine()->getManager();
        // vérifie que les Entitées ne sont pas vides
        $nbEntities = count($this->entities);

        for ($index = 0; $index < $nbEntities; $index++) {
            $entity = $etm->getRepository(
                $this->entities[$index]
            );
            $entityData = $entity->find(1);

            if (empty($entityData)) {
                $message = 'gestock.install.none';
//                $url = 'gs_install'; break;
                $url = '_home'; break;
            } elseif ($index === 10 && $entityData->getFirstInventory() === null) {
                $message = 'gestock.settings.application.first_inventory.none';
//                $url = 'gestock_inventory_prepare'; break;
                $url = '_home'; break;
            }
        }
        if (isset($message)) {
            $this->container->get('session')->getFlashBag()->add('warning', $message);
        }
        return $url;
    }
}
