<?php
/**
 * InvoicesController controller de la facturation.
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
use AppBundle\Form\Type\InvoicesEditType;

/**
 * Invoices controller.
 *
 * @Route("/invoices")
 */
class InvoicesController extends AbstractOrdersController
{
    /**
     * Lists all Orders entities.
     *
     * @Route("/", name="invoices")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $etm = $this->getDoctrine()->getManager();
        $item = $this->container->getParameter('knp_paginator.page_range');
        $qbd = $etm->getRepository('AppBundle:Orders')->findInvoices();
        
        $paginator = $this->get('knp_paginator')->paginate($qbd, $request->query->get('page', 1), $item);
        return array(
            'paginator' => $paginator,
        );
    }

    /**
     * Finds and displays a Orders entity.
     *
     * @Route("/{id}/show", name="invoices_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Orders $orders)
    {
        return array(
            'orders' => $orders,
        );
    }

    /**
     * Displays a form to edit an existing Orders entity.
     *
     * @Route("/admin/{id}/edit", name="invoices_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Orders $orders)
    {
        $return = $this->abstractEditAction($orders, 'invoices', InvoicesEditType::class);

        return $return;
    }

    /**
     * Edits an existing Orders entity.
     *
     * @Route("/admin/{id}/update", name="invoices_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Deliveries:edit.html.twig")
     */
    public function updateAction(Orders $orders, Request $request)
    {
        $etm = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(InvoicesEditType::class, $orders, array(
            'action' => $this->generateUrl('invoices_update', array('id' => $orders->getId())),
            'method' => 'PUT',
        ));
        $editForm->handleRequest($request);

        $return = array(
            'orders' => $orders,
            'edit_form'   => $editForm->createView(),
        );
        
        if ($editForm->isValid()) {
            $orders->setStatus(3);
            $etm->persist($orders);
            $this->updateArticles($orders, $etm);
            $this->addFlash('info', 'gestock.edit.ok');
            $etm->flush();

            $return = $this->redirect($this->generateUrl('_home'));
        }

        return $return;
    }

    /**
     * Print the current invoice.<br />Creating a `PDF` file for viewing on paper
     *
     * @Route("/{id}/print/", name="invoices_print", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Orders $orders Order item to print
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function printAction(Orders $orders)
    {
        $return = $this->abstractPrintAction($orders, 'Invoices');
        
        return $return;
    }

    /**
     * Update Articles.
     *
     * @param \AppBundle\Entity\Orders   $orders   Articles de la commande à traiter
     * @param \Doctrine\Common\Persistence\ObjectManager $etm Entity Manager
     */
    private function updateArticles(Orders $orders, $etm)
    {
        $articles = $etm->getRepository('AppBundle:Article')->getArticleFromSupplier($orders->getSupplier()->getId());
        foreach ($orders->getArticles() as $line) {
            foreach ($articles as $art) {
                if ($art->getId() === $line->getArticle()->getId() && $art->getPrice() !== $line->getPrice()) {
                    $stockAmount = ($art->getQuantity() - $line->getQuantity()) * $art->getPrice();
                    $orderAmount = $line->getQuantity() * $line->getPrice();
                    $newPrice = ($stockAmount + $orderAmount) / $art->getQuantity();
                    $art->setPrice($newPrice);
                    $etm->persist($art);
                }
            }
        }
    }
}
