<?php
/**
 * DefaultController controller des fournisseurs.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version   since 1.0.0
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Supplier;

/**
 * Supplier controller.
 *
 * @category Controller
 *
 * @Route("/supplier")
 */
class SupplierController extends AbstractController
{
    /**
     * Lists all Supplier entities.
     *
     * @Route("/", name="supplier")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $etm = $this->getDoctrine()->getManager();
        $qb = $etm->getRepository('AppBundle:Supplier')->getSuppliers();
        $this->addQueryBuilderSort($qb, 'supplier');
        $paginator = $this->get('knp_paginator')->paginate($qb, $request->query->get('page', 1), 20);
        
        return array(
            'paginator' => $paginator,
        );
    }

    /**
     * Finds and displays a Supplier entity.
     *
     * @Route("/{slug}/show", name="supplier_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Supplier $supplier)
    {
        $etm = $this->getDoctrine()->getManager();
        
        $deleteForm = $this->createDeleteForm($supplier->getId(), 'supplier_delete');

        // Récupérer les articles du fournisseur.
        $articles = $etm->getRepository('AppBundle:Article')->getArticleFromSupplier($supplier);
        return array(
            'supplier' => $supplier,
            'articles' => $articles,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Supplier entity.
     *
     * @Route("/admin/new", name="supplier_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'Supplier',
            'AppBundle\Entity\Supplier',
            'AppBundle\Form\Type\SupplierType'
        );

        return $return;
    }

    /**
     * Creates a new Supplier entity.
     *
     * @Route("/create", name="supplier_create")
     * @Method("POST")
     * @Template("AppBundle:Supplier:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'supplier',
            'AppBundle\Entity\Supplier',
            'AppBundle\Form\Type\SupplierType'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing Supplier entity.
     *
     * @Route("/admin/{slug}/edit", name="supplier_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Supplier $supplier)
    {
        $return = $this->abstractEditAction(
            $supplier,
            'supplier',
            'AppBundle\Form\Type\SupplierType'
        );

        return $return;
    }

    /**
     * Edits an existing Supplier entity.
     *
     * @Route("/{slug}/update", name="supplier_update")
     * @Method("PUT")
     * @Template("AppBundle:Supplier:edit.html.twig")
     */
    public function updateAction(Supplier $supplier, Request $request)
    {
        $return = $this->abstractUpdateAction(
            $supplier,
            $request,
            'supplier',
            'AppBundle\Form\Type\SupplierType'
        );

        return $return;
    }


    /**
     * Save order.
     *
     * @Route("/order/{field}/{type}", name="supplier_sort")
     */
    public function sortAction($field, $type)
    {
        $this->setOrder('supplier', $field, $type);

        return $this->redirectToRoute('supplier');
    }

    /**
     * Deletes a Supplier entity.
     *
     * @Route("/admin/{id}/delete", name="supplier_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Supplier $supplier, Request $request)
    {
        $etm = $this->getDoctrine()->getManager();
        // Test if there is no articles with this supplier.
        $articles = $etm->getRepository('AppBundle:Article')->getArticleFromSupplier($supplier);
        if (!empty($articles)) {
            $message = $this->get('translator')
                ->trans('delete.reassign_wrong', array(), 'gs_suppliers');
            $this->addFlash('danger', $message);
            return $this->redirectToRoute('articles_reassign', array('slug' => $supplier->getSlug()));
        }

        $this->abstractDeleteAction($supplier, $request, 'supplier');

        return $this->redirectToRoute('supplier');
    }
}
