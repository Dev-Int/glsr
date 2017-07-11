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
 * @version GIT: <git_id>
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
            ['1', 'AppBundle:Staff\Group'],
            ['2', 'AppBundle:Staff\User'],
            ['3','AppBundle:Settings\Company'],
            ['4', 'AppBundle:Settings\Settings'],
            ['5_1', 'AppBundle:Settings\Diverse\FamilyLog'],
            ['5_2','AppBundle:Settings\Diverse\ZoneStorage'],
            ['5_3', 'AppBundle:Settings\Diverse\Unit'],
            ['5_4', 'AppBundle:Settings\Diverse\Tva'],
            ['6', 'AppBundle:Settings\Supplier'],
            ['7', 'AppBundle:Settings\Article'],
            ['8', 'AppBundle:Stocks\Inventory'],);
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
            $redirect = $this->render('default/index.html.twig');
        } else {
            $redirect = $this->redirectToRoute($url[0], ['step' => $url[1]]);
        }

        return $redirect;
    }

    /**
     * Get stock alerts.
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
        $listArticles = $etm->getRepository('AppBundle:Settings\Article')->getStockAlert($number);
        $helper = $this->get('app.helper.controller');
        foreach ($listArticles as $key => $article) {
            // Tester la liste si un fournisseur à déjà une commande en cours
            if ($helper->isOrderInProgress($article, $etm)) {
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
        $listInventories = $etm->getRepository('AppBundle:Stocks\Inventory')->getLastInventory($number);

        return array('listInventory' => $listInventories);
    }

    /**
     * Get the latest orders.
     *
     * @Route("/alert", name="lastorders")
     * @Method("GET")
     * @Template("default/lastorder.html.twig")
     *
     * @param integer $number Number of orders to display
     * @return array|null
     */
    public function lastOrdersAction($number)
    {
        $etm = $this->getDoctrine()->getManager();
        $listOrders = $etm->getRepository('AppBundle:Orders\Orders')->getLastOrder($number);

        return array('listOrders' => $listOrders);
    }

    /**
     * Get the latest deliveries.
     *
     * @Route("/alert", name="lastorders")
     * @Method("GET")
     * @Template("default/lastDelivery.html.twig")
     *
     * @param integer $number Number of orders to display
     * @return array|null
     */
    public function lastDeliveriesAction($number)
    {
        $etm = $this->getDoctrine()->getManager();
        $listDeliveries = $etm->getRepository('AppBundle:Orders\Orders')->getLastDelivery($number);

        return array('listDeliveries' => $listDeliveries);
    }

    /**
     * Get the latest invoices.
     *
     * @Route("/alert", name="lastorders")
     * @Method("GET")
     * @Template("default/lastInvoice.html.twig")
     *
     * @param integer $number Number of orders to display
     * @return array|null
     */
    public function lastInvoicesAction($number)
    {
        $etm = $this->getDoctrine()->getManager();
        $listInvoices = $etm->getRepository('AppBundle:Orders\Orders')->getLastInvoice($number);

        return ['listInvoices' => $listInvoices];
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
            $entity = $etm->getRepository($this->entities[$index][1]);
            $entityData = $entity->findAll();

            if (empty($entityData)) {
                $message = 'gestock.install.none';
                $url = ['gs_install', $this->entities[$index][0]];
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
                    ->getRepository('AppBundle:Settings\Supplier')
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
}
