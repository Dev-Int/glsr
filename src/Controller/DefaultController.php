<?php
/**
 * DefaultController Controller of the GLSR application.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @see      https://github.com/Dev-Int/glsr
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Default controller.
 *
 * @category Controller
 *
 * @Route("/")
 */
class DefaultController extends AbstractController
{
    /**
     * Array of the entities.
     *
     * @var array
     */
    private $entities = [];

    public function __construct()
    {
        // Tableau des entitées
        $this->entities = array(
            ['1', 'App:Staff\Group'],
            ['2', 'App:Staff\User'],
            ['3', 'App:Settings\Company'],
            ['4', 'App:Settings\Settings'],
            ['5_1', 'App:Settings\Diverse\FamilyLog'],
            ['5_2', 'App:Settings\Diverse\ZoneStorage'],
            ['5_3', 'App:Settings\Diverse\Unit'],
            ['5_4', 'App:Settings\Diverse\Tva'],
            ['6', 'App:Settings\Supplier'],
            ['7', 'App:Settings\Article'],
            ['8', 'App:Settings\Diverse\Material'],
            ['9', 'App:Stocks\Inventory'], );
    }

    /**
     * @Route("/", name="_home")
     * @Method("GET")
     * @Template()
     *
     * @return \Symfony\Component\HttpFoundation\Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function index()
    {
        /**
         * Installation test.
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
     * @param int $number number of alerts to display
     *
     * @return array|null
     */
    public function stockAlert($number)
    {
        $etm = $this->getDoctrine()->getManager();
        $listArticles = $etm->getRepository('App:Settings\Article')->getStockAlert($number);
        $helper = $this->get('app.helper.controller');
        foreach ($listArticles as $key => $article) {
            // Test the list if a supplier already has an order in progress
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
     * @param int $number Number of inventories to display
     *
     * @return array|null
     */
    public function lastInventory($number)
    {
        $etm = $this->getDoctrine()->getManager();
        $listInventories = $etm->getRepository('App:Stocks\Inventory')->getLastInventory($number);

        return array('listInventory' => $listInventories);
    }

    /**
     * Get the latest orders.
     *
     * @Route("/alert", name="lastorders")
     * @Method("GET")
     * @Template("default/lastOrder.html.twig")
     *
     * @param int $number Number of orders to display
     *
     * @return array|null
     */
    public function lastOrders($number)
    {
        $etm = $this->getDoctrine()->getManager();
        $listOrders = $etm->getRepository('App:Orders\Orders')->getLastOrder($number);

        return array('listOrders' => $listOrders);
    }

    /**
     * Get the latest deliveries.
     *
     * @Route("/alert", name="lastorders")
     * @Method("GET")
     * @Template("default/lastDelivery.html.twig")
     *
     * @param int $number Number of orders to display
     *
     * @return array|null
     */
    public function lastDeliveries($number)
    {
        $etm = $this->getDoctrine()->getManager();
        $listDeliveries = $etm->getRepository('App:Orders\Orders')->getLastDelivery($number);

        return array('listDeliveries' => $listDeliveries);
    }

    /**
     * Get the latest invoices.
     *
     * @Route("/alert", name="lastorders")
     * @Method("GET")
     * @Template("default/lastInvoice.html.twig")
     *
     * @param int $number Number of orders to display
     *
     * @return array|null
     */
    public function lastInvoices($number)
    {
        $etm = $this->getDoctrine()->getManager();
        $listInvoices = $etm->getRepository('App:Orders\Orders')->getLastInvoice($number);

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
        // Check that Entities are not empty
        $nbEntities = count($this->entities);
        for ($index = 0; $index < $nbEntities; ++$index) {
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
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFamilyLog(Request $request)
    {
        $return = new Response('Error');
        $etm = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $familyLog = array();
            $id = $request->get('id');
            if ('' != $id) {
                $supplier = $etm
                    ->getRepository('App:Settings\Supplier')
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
