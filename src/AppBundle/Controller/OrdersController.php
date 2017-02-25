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
 * @version since 1.0.0
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AbstractOrdersController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use AppBundle\Entity\Orders;
use AppBundle\Entity\Supplier;
use AppBundle\Form\Type\OrdersType;
use AppBundle\Form\Type\OrdersEditType;
use AppBundle\Entity\OrdersArticles;

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
        $etm = $this->getDoctrine()->getManager();
        $item = $this->container->getParameter('knp_paginator.page_range');
        $qbd = $etm->getRepository('AppBundle:Orders')->createQueryBuilder('o');
        $qbd->where('o.delivdate > ' . date('Y-m-d'));
        $qbd->andWhere('o.status = 1');
        
        $createForm = $this->createCreateForm('orders_create');

        $paginator = $this->get('knp_paginator')->paginate($qbd, $request->query->get('page', 1), $item);
        return array(
            'create_form' => $createForm->createView(),
            'paginator' => $paginator,
        );
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
        $articles = $etm->getRepository('AppBundle:Article')->getArticleFromSupplier($supplier->getId());

        // Set Orders dates (order and delivery)
        $orders = $this->setDates($orders, $supplier);

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
     * @Template("AppBundle:Orders:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $etm = $this->getDoctrine()->getManager();

        $orders = new Orders();
        $form = $this->createForm(OrdersType::class, $orders);
        $return = ['orders' => $orders, 'form' => $form->createView(),];
        $form->handleRequest($request);
        $supplier = $orders->getSupplier();
        $articles = $etm->getRepository('AppBundle:Article')->getArticleFromSupplier($supplier->getId());
        // Tester la liste si un fournisseur à déjà une commande en cours
        $test = $this->get('app.helper.controller')->hasSupplierArticles($articles);
        if ($test === false) {
            $return = $this->redirectToRoute('orders');
        } else {
            // Set Orders dates (order and delivery)
            $orders = $this->setDates($orders, $supplier);

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
        $editForm = $this->createForm(OrdersEditType::class, $orders, array(
            'action' => $this->generateUrl('orders_update', array('id' => $orders->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($orders->getId(), 'orders_delete');

        return array(
            'orders' => $orders,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Orders entity.
     *
     * @Route("/admin/{id}/update", name="orders_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Orders:edit.html.twig")
     */
    public function updateAction(Orders $orders, Request $request)
    {
        $editForm = $this->createForm(OrdersEditType::class, $orders, array(
            'action' => $this->generateUrl('orders_update', array('id' => $orders->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($orders->getId(), 'orders_delete');
        $editForm->handleRequest($request);

        $return = array(
            'orders' => $orders,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        
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
        $return = $this->abstractDeleteWithArticlesAction($orders, $request, 'orders');
        
        return $return;
    }

    /**
     * Set order Dates.
     *
     * @param \AppBundle\Entity\Orders   $orders   La commande à traiter
     * @param \AppBundle\Entity\Supplier $supplier Le fournisseur concerné
     * @return \AppBundle\Entity\Orders            La commande modifiée
     */
    private function setDates(Orders $orders, Supplier $supplier)
    {
        $orderDate = $supplier->getOrderdate();
        foreach ($orderDate as $date) {
            if ($date >= date('w')) {
                $diffOrder = $date - date('w');
                $diffDeliv = $diffOrder + $supplier->getDelaydeliv();
                $dateOrder = date('Y-m-d H:i:s', mktime(0, 0, 0, date('n'), date('j')+$diffOrder, date('Y')));
                $delivDate = date('Y-m-d H:i:s', mktime(0, 0, 0, date('n'), date('j')+$diffDeliv, date('Y')));
                $setOrderDate = \DateTime::createFromFormat('Y-m-d H:i:s', $dateOrder);
                $setDelivDate = \DateTime::createFromFormat('Y-m-d H:i:s', $delivDate);
                if ($setOrderDate !== false && $setDelivDate !== false){
                    $orders->setOrderDate($setOrderDate);
                    $orders->setDelivDate($setDelivDate);
                    break;
                }
            }
        }
        return $orders;
    }

    /**
     * Save OrdersArticles.
     *
     * @param array                      $articles Liste des articles
     * @param \AppBundle\Entity\Orders   $orders   La commande à traiter
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
     * @param \AppBundle\Entity\Orders $orders Order item to print
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function printAction(Orders $orders)
    {
        $return = $this->abstractPrintAction($orders, 'Orders');
        
        return $return;
    }
}
