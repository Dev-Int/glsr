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
     *
     * @return \Symfony\Component\HttpFoundation\Response|\Symfony\Component\HttpFoundation\RedirectResponse
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
     * Get Alerts.
     *
     * @Route("/alert", name="stockalert")
     * @Method("GET")
     * @Template("default/stockAlert.html.twig")
     *
     * @param integer $number Number of alerts to display.
     * @return array|null
     */
    public function stockAlertAction($number)
    {
        $etm = $this->getDoctrine()->getManager();
        $listArticles = $etm->getRepository('AppBundle:Article')->getStockAlert($number);
        // Tester la liste si un fournisseur à déjà une commande en cours
        $helper = $this->get('app.helper.controller');
        foreach ($listArticles as $key => $article) {
            if ($helper->testCreate($article, $etm)) {
                unset($listArticles[$key]);
            }
        }

        return array('listArticles' => $listArticles);
    }

    /**
     * Get the latest inventories.
     *
     * @Route("/alert", name="lastinventories")
     * @Method("GET")
     * @Template("default/lastInventory.html.twig")
     *
     * @param integer $number Number of inventories to display
     * @return array|null
     */
    public function lastInventoryAction($number)
    {
        $etm = $this->getDoctrine()->getManager();
        $listInventories = $etm->getRepository('AppBundle:Inventory')->getLastInventory($number);

        return array('listInventory' => $listInventories);
    }

    /**
     * Test entities.
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
     * Get FamilyLog.
     *
     * @Route("/getfamilylog", name="getfamilylog")
     * @Method("POST")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Post request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFamilyLogAction(Request $request)
    {
        $return = new Response('Error');
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
                $return = $response;
            }
        }
        return $return;
    }

    /**
     * Tests of creation conditions.
     *
     * @param array $article Articles à tester
     * @return boolean
     */
    public function testCreate($article, $etm)
    {
        $return = false;
        $orders = $etm->getRepository('AppBundle:Orders')->findAll();
        // This provider already has an order in progress!
        foreach ($orders as $order) {
            if ($order->getSupplier() === $article->getSupplier()) {
                $return = true;
            }
        }
        return $return;
    }
}
