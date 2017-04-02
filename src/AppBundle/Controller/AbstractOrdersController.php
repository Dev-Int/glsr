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
 * @version since 1.0.0
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller;

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
}
