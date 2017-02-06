<?php
/**
 * DeliveriesController controller des livraisons.
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
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use AppBundle\Entity\Orders;
use AppBundle\Form\Type\OrdersEditType;

/**
 * Orders controller.
 *
 * @Route("/deliveries")
 */
class DeliveriesController extends AbstractOrdersController
{
    /**
     * Lists all Orders entities.
     *
     * @Route("/", name="deliveries")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $etm = $this->getDoctrine()->getManager();
        $item = $this->container->getParameter('knp_paginator.page_range');
        $qbd = $etm->getRepository('AppBundle:Orders')->createQueryBuilder('o');
        $qbd->where('o.delivdate >= ' . date('Y-m-d'));
        $qbd->andWhere('o.status = 1');
        
        $paginator = $this->get('knp_paginator')->paginate($qbd, $request->query->get('page', 1), $item);
        return array(
            'paginator' => $paginator,
        );
    }

    /**
     * Finds and displays a Orders entity.
     *
     * @Route("/{id}/show", name="deliveries_show", requirements={"id"="\d+"})
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
     * @Route("/admin/{id}/edit", name="deliveries_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Orders $orders)
    {
        $editForm = $this->createForm(OrdersEditType::class, $orders, array(
            'action' => $this->generateUrl('deliveries_update', array('id' => $orders->getId())),
            'method' => 'PUT',
        ));

        return array(
            'orders' => $orders,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Orders entity.
     *
     * @Route("/admin/{id}/update", name="deliveries_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Deliveries:edit.html.twig")
     */
    public function updateAction(Orders $orders, Request $request)
    {
        $etm = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(OrdersEditType::class, $orders, array(
            'action' => $this->generateUrl('deliveries_update', array('id' => $orders->getId())),
            'method' => 'PUT',
        ));
        $editForm->handleRequest($request);

        $return = array(
            'orders' => $orders,
            'edit_form'   => $editForm->createView(),
        );
        
        if ($editForm->isValid()) {
            $orders->setStatus(2);
            $etm->persist($orders);
            $this->updateArticles($orders, $etm);
            $this->addFlash('info', 'gestock.edit.ok');
            $etm->flush();

            $return = $this->redirect($this->generateUrl('_home'));
        }

        return $return;
    }

    /**
     * Print the current delivery.<br />Creating a `PDF` file for viewing on paper
     *
     * @Route("/{id}/print/", name="deliveries_print", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Inventory $orders Inventory item to print
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function printAction(Orders $orders)
    {
        $file = 'delivery-' . $orders->getId() . '.pdf';
        $company = $this->getDoctrine()->getManager()->getRepository('AppBundle:Company')->find(1);
        // Create and save the PDF file to print
        $html = $this->renderView(
            'AppBundle:Deliveries:print.pdf.twig',
            ['articles' => $orders->getArticles(), 'orders' => $orders, 'company' => $company, ]
        );
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                $this->getArray((string)date('d/m/y - H:i:s'), '')
            ),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $file . '"'
            )
        );
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
                if ($art->getId() === $line->getArticle()->getId()) {
                    $art->setQuantity($line->getQuantity() + $art->getQuantity());
                    $etm->persist($art);
                }
            }
        }
    }
}
