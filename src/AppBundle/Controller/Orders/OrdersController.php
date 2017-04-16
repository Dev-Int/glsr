<?php
/**
 * OrdersController controller des commandes.
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
namespace AppBundle\Controller\Orders;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Orders\AbstractOrdersController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use AppBundle\Entity\Orders\Orders;
use AppBundle\Entity\Settings\Supplier;
use AppBundle\Form\Type\Orders\OrdersType;
use AppBundle\Form\Type\Orders\OrdersEditType;
use AppBundle\Entity\Orders\OrdersArticles;

/**
 * Orders controller.
 *
 * @Route("/orders")
 */
class OrdersController extends AbstractOrdersController
{
    /**
     * Lists all Orders entities.
     *
     * @Route("/", name="orders")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $return = $this->abstractIndexAction('Orders\Orders', 'orders', $request);

        $createForm = $this->createCreateForm('orders_create');
        $return['create_form'] = $createForm->createView();

        return $return;
    }

    /**
     * Finds and displays a Orders entity.
     *
     * @Route("/{id}/show", name="orders_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Orders $orders)
    {
        $deleteForm = $this->createDeleteForm($orders->getId(), 'orders_delete');

        return array(
            'orders' => $orders,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Orders entity.
     *
     * @Route("/new/{supplier}", name="orders_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Supplier $supplier)
    {
        $etm = $this->getDoctrine()->getManager();

        $orders = new Orders();
        $orders->setSupplier($supplier);
        $articles = $etm->getRepository('AppBundle:Settings\Article')->getArticleFromSupplier($supplier->getId());

        // Set Orders dates (order and delivery)
        $orderDate = $supplier->getOrderdate();
        foreach ($orderDate as $date) {
            $orders = $this->setDates($date, $orders, $supplier);
        }

        $etm->persist($orders);
        // Saving articles of supplier in order
        $this->saveOrdersArticles($articles, $orders, $etm);

        $etm->flush();

        return $this->redirect($this->generateUrl('orders_edit', array('id' => $orders->getId())));
    }

    /**
     * Creates a new Orders entity.
     *
     * @Route("/admin/create", name="orders_create")
     * @Method("POST")
     * @Template("AppBundle:Orders/Orders:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $etm = $this->getDoctrine()->getManager();

        $orders = new Orders();
        $form = $this->createForm(OrdersType::class, $orders);
        $return = ['orders' => $orders, 'form' => $form->createView(),];
        $form->handleRequest($request);
        $supplier = $orders->getSupplier();
        $articles = $etm->getRepository('AppBundle:Settings\Article')->getArticleFromSupplier($supplier->getId());
        // Tester la liste si un fournisseur à déjà une commande en cours
        $test = $this->get('app.helper.controller')->hasSupplierArticles($articles);
        if ($test === false) {
            $return = $this->redirectToRoute('orders');
        } else {
            // Set Orders dates (order and delivery)
            $orderDate = $supplier->getOrderdate();
            foreach ($orderDate as $date) {
                $orders = $this->setDates($date, $orders, $supplier);
            }

            if ($form->isValid() && $return !== $this->redirectToRoute('orders')) {
                $etm->persist($orders);
                // Saving articles of supplier in order
                $this->saveOrdersArticles($articles, $orders, $etm);

                $etm->flush();

                $return = $this->redirect($this->generateUrl('orders_edit', array('id' => $orders->getId())));
            }
        }
        return $return;
    }

    /**
     * Displays a form to edit an existing Orders entity.
     *
     * @Route("/admin/{id}/edit", name="orders_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Orders $orders)
    {
        $editForm = $this->createForm(OrdersEditType::class, $orders, ['action' => $this
            ->generateUrl('orders_update', ['id' => $orders->getId()]), 'method' => 'PUT',]);
        $deleteForm = $this->createDeleteForm($orders->getId(), 'orders_delete');

        return ['orders' => $orders, 'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),];
    }

    /**
     * Edits an existing Orders entity.
     *
     * @Route("/admin/{id}/update", name="orders_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Orders/Orders:edit.html.twig")
     */
    public function updateAction(Orders $orders, Request $request)
    {
        $editForm = $this->createForm(OrdersEditType::class, $orders, ['action' => $this
            ->generateUrl('orders_update', ['id' => $orders->getId()]), 'method' => 'PUT',]);
        $deleteForm = $this->createDeleteForm($orders->getId(), 'orders_delete');
        $editForm->handleRequest($request);

        $return = ['orders' => $orders, 'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),];
        
        if ($editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'gestock.edit.ok');

            $return = $this->redirect($this->generateUrl('orders_edit', ['id' => $orders->getId()]));
        }

        return $return;
    }

    /**
     * Deletes a Orders entity.
     *
     * @Route("/admin/{id}/delete", name="orders_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Orders $orders, Request $request)
    {
        $return = $this->abstractDeleteWithArticlesAction($orders, $request, 'Orders\Orders', 'orders');
        
        return $return;
    }

    /**
     * Set order Dates.
     *
     * @param integer                             $date     Jour de la commande
     * @param \AppBundle\Entity\Orders\Orders     $orders   La commande à traiter
     * @param \AppBundle\Entity\Settings\Supplier $supplier Le fournisseur concerné
     * @return \AppBundle\Entity\Orders\Orders La commande modifiée
     */
    private function setDates($date, Orders $orders, Supplier $supplier)
    {
        $setOrderDate = new \DateTime(date('Y-m-d'));
        if ($date >= date('w')) {
            $diffOrder = $date - date('w');
            $setOrderDate->add(new \DateInterval('P'.$diffOrder.'DT18H'));
            $diffDeliv = $this->get('app.helper.time')
                ->getNextOpenDay($setOrderDate->getTimestamp(), $supplier->getDelaydeliv());

            $setDelivDate = new \DateTime(date('Y-m-d', $setOrderDate->getTimestamp()));
            $setDelivDate->add(new \DateInterval('P'.$diffDeliv.'D'));

            $orders->setOrderdate($setOrderDate);
            $orders->setDelivdate($setDelivDate);
        }
        return $orders;
    }

    /**
     * Save OrdersArticles.
     *
     * @param array                             $articles Liste des articles
     * @param \AppBundle\Entity\Orders\Orders   $orders   La commande à traiter
     * @param \Doctrine\Common\Persistence\ObjectManager $etm Entity Manager
     */
    private function saveOrdersArticles($articles, $orders, $etm)
    {
        foreach ($articles as $article) {
            $ordersArticles = new OrdersArticles();
            $ordersArticles->setOrders($orders);
            $ordersArticles->setArticle($article);
            $ordersArticles->setUnitStorage($article->getUnitStorage());
            if ($article->getMinstock() > $article->getQuantity()) {
                $ordersArticles->setQuantity($article->getMinstock() - $article->getQuantity());
            }
            $ordersArticles->setPrice($article->getPrice());
            $ordersArticles->setTva($article->getTva());
            $etm->persist($ordersArticles);
        }
    }

    /**
     * Print the current order.<br />Creating a `PDF` file for viewing on paper
     *
     * @Route("/{id}/print/", name="orders_print", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Orders\Orders $orders Order item to print
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function printAction(Orders $orders)
    {
        $return = $this->abstractPrintAction($orders, 'Orders');
        
        return $return;
    }
}
