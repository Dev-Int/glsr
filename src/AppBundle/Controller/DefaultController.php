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
            'AppBundle:Staff\User',
            'AppBundle:Settings\Company',
            'AppBundle:Settings\Settings',
            'AppBundle:Settings\Diverse\FamilyLog',
            'AppBundle:Settings\Diverse\ZoneStorage',
            'AppBundle:Settings\Diverse\UnitStorage',
            'AppBundle:Settings\Diverse\Tva',
            'AppBundle:Settings\Supplier',
            'AppBundle:Settings\Article');
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

        return $url;
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
