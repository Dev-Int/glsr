<?php
/**
 * AbstractOrdersController Méthodes communes InventoryController.
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
use AppBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Orders;
use AppBundle\Form\Type\OrdersType;

/**
 * Abstract controller.
 *
 * @category Controller
 */
class AbstractOrdersController extends AbstractController
{
    /**
     * Create CreateForm.
     *
     * @param string $route Route of action form
     * @return \Symfony\Component\Form\Form
     */
    protected function createCreateForm($route)
    {
        $orders = new Orders();
        return $this->createForm(
            OrdersType::class,
            $orders,
            ['attr' => ['id' => 'create'], 'action' => $this->generateUrl($route), 'method' => 'POST',]
        );
    }

    /**
     * Displays a form to edit an existing item entity.
     *
     * @param Object $entity     Entity
     * @param string $entityName Name of Entity
     * @param string $typePath   Path of FormType
     * @return array
     */
    public function abstractEditAction($entity, $entityName, $typePath)
    {
        $param = $this->get('app.helper.controller')->testReturnParam($entity, $entityName);
        $editForm = $this->createForm($typePath, $entity, array(
            'action' => $this->generateUrl($entityName.'_update', $param),
            'method' => 'PUT',
        ));
        if ($entityName === 'group') {
            $this->addRolesAction($editForm, $entity);
        }

        return [$entityName => $entity, 'edit_form' => $editForm->createView(),];
    }

    /**
     * Edits an existing item entity.
     *
     * @param Object                                    $entity     Entity
     * @param \Symfony\Component\HttpFoundation\Request $request    Request in progress
     * @param string                                    $entityName Name of Entity
     * @param string                                    $typePath   Path of FormType
     * @return array
     */
    public function abstractUpdateAction($entity, Request $request, $entityName, $typePath)
    {
        $etm = $this->getDoctrine()->getManager();
        $param = $this->get('app.helper.controller')->testReturnParam($entity, $entityName);
        $editForm = $this->createForm($typePath, $entity, array(
            'action' => $this->generateUrl($entityName.'_update', $param),
            'method' => 'PUT',
        ));

        $editForm->handleRequest($request);

        $return = [$entityName => $entity, 'edit_form'   => $editForm->createView(), ];

        if ($editForm->isValid()) {
            if ($entityName === 'deliveries') {
                $entity->setStatus(2);
                $this->updateDeliveryArticles($entity, $etm);
            }
            if ($entityName === 'invoices') {
                $entity->setStatus(3);
                $this->updateInvoiceArticles($entity, $etm);
            }
            $etm->persist($entity);
            $etm->flush();

            $this->addFlash('info', 'gestock.edit.ok');

            $return = $this->redirectToRoute('_home');
        }

        return $return;
    }

    /**
     * Print a document.<br />Creating a `PDF` file for viewing on paper
     *
     * @param \AppBundle\Entity\Orders $orders Order item to print
     * @param string $from The Controller who call this action
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function abstractPrintAction(Orders $orders, $from)
    {
        $file = $from . '-' . $orders->getId() . '.pdf';
        $company = $this->getDoctrine()->getManager()->getRepository('AppBundle:Company')->find(1);
        // Create and save the PDF file to print
        $html = $this->renderView(
            'AppBundle:' . $from . ':print.pdf.twig',
            ['articles' => $orders->getArticles(), 'orders' => $orders, 'company' => $company, ]
        );
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                $this->get('app.helper.controller')->getArray((string)date('d/m/y - H:i:s'), '')
            ),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $file . '"'
            )
        );
    }

    /**
     * Update Articles for deliveries.
     *
     * @param \AppBundle\Entity\Orders $orders Articles de la commande à traiter
     * @param \Doctrine\Common\Persistence\ObjectManager $etm Entity Manager
     */
    private function updateDeliveryArticles(Orders $orders, $etm)
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

    /**
     * Update Articles for invoices.
     *
     * @param \AppBundle\Entity\Orders $orders Articles de la commande à traiter
     * @param \Doctrine\Common\Persistence\ObjectManager $etm Entity Manager
     */
    private function updateInvoiceArticles(Orders $orders, $etm)
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
