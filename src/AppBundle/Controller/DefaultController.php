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
 * @version since 1.0.0
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Default controller.
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
            'AppBundle:ZoneStorage',
            'AppBundle:UnitStorage',
            'AppBundle:Tva',
            'AppBundle:Supplier',
            'AppBundle:Article');

    }

    /**
     * @Route("/", name="_home")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        /**
         * Test d'installation.
         */
        $url = $this->testEntities();
        if (empty($url)) {
            $url = $this->render('default/index.html.twig');
        } else {
            $url = $this->redirectToRoute($url);
        }

        /**
         * Affichage du dernier inventaire.
         */
        /**
         * Affichage des stocks d'alerte.
         */
        return $url;
    }

    /**
     * Récupérer les Alertes.
     *
     * @param integer $number nombres d'alertes à afficher
     * @Route("/alert", name="stockalert")
     * @Method("GET")
     * @Template("default/stockAlert.html.twig")
     *
     * @return array|null
     */
    public function stockAlertAction($number)
    {
        $etm = $this->getDoctrine()->getManager();
        $listArticles = $etm->getRepository('AppBundle:Article')->getStockAlert($number);

        return array('listArticles' => $listArticles);
    }

    /**
     * Récupérer les Alertes.
     *
     * @param integer $number nombres d'alertes à afficher
     * @Route("/alert", name="stockalert")
     * @Method("GET")
     * @Template("default/lastInventory.html.twig")
     *
     * @return array|null
     */
    public function lastInventoryAction($number)
    {
        $etm = $this->getDoctrine()->getManager();
        $listInventories = $etm->getRepository('AppBundle:Inventory')->getLastInventory($number);

        return array('listInventory' => $listInventories);
    }

    /**
     * Test des entités
     *
     * @return string|null
     */
    private function testEntities()
    {
        $url = null;
        $etm = $this->getDoctrine()->getManager();
        // vérifie que les Entitées ne sont pas vides
        $nbEntities = count($this->entities);
        for ($index = 0; $index < $nbEntities; $index++) {
            $entity = $etm->getRepository($this->entities[$index]);
            $entityData = $entity->find(1);

            if (empty($entityData)) {
                $message = 'gestock.install.none';
                $url = 'gs_install';
                break;
            }
        }
        if (isset($message)) {
            $this->addFlash('warning', $message);
        }
        return $url;
    }

    /**
     * Récupère les FamilyLog de la requête post.
     *
     * @Route("/getfamilylog", name="getfamilylog")
     * @Method("POST")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFamilyLogAction(Request $request)
    {
        $etm = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $familyLog = array();
            $id = $request->get('id');
            if ($id != '') {
                $supplier = $etm
                    ->getRepository('AppBundle:Supplier')
                    ->find($id);
                $familyLog['familylog'] = $supplier->getFamilyLog()->getId();
                $response = new Response();
                $data = json_encode($familyLog);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($data);
                return $response;
            }
        }
        return new Response('Error');
    }
}
