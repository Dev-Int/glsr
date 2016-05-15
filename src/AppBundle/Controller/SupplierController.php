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
use AppBundle\Form\Type\SupplierType;

/**
 * Supplier controller.
 *
 * @category Controller
 *
 * @Route("/suppliers")
 */
class SupplierController extends AbstractController
{
    /**
     * Lists all Supplier entities.
     *
     * @Route("/", name="suppliers")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Supplier')->getSuppliers();
        $this->addQueryBuilderSort($qb, 'supplier');
        $paginator = $this->get('knp_paginator')->paginate($qb, $request->query->get('page', 1), 20);
        
        return array(
            'paginator' => $paginator,
        );
    }

    /**
     * Finds and displays a Supplier entity.
     *
     * @Route("/{slug}/show", name="suppliers_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Supplier $supplier)
    {
        $em = $this->getDoctrine()->getManager();
        
        $deleteForm = $this->createDeleteForm($supplier->getId(), 'suppliers_delete');

        // Récupérer les articles du fournisseur.
        $articles = $em->getRepository('AppBundle:Article')->getArticleFromSupplier($supplier);
        return array(
            'supplier' => $supplier,
            'articles' => $articles,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Supplier entity.
     *
     * @Route("/admin/new", name="suppliers_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $supplier = new Supplier();
        $form = $this->createForm(new SupplierType(), $supplier);

        return array(
            'supplier' => $supplier,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Supplier entity.
     *
     * @Route("/create", name="suppliers_create")
     * @Method("POST")
     * @Template("AppBundle:Supplier:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $supplier = new Supplier();
        $form = $this->createForm(new SupplierType(), $supplier);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($supplier);
            $em->flush();

            return $this->redirectToRoute('suppliers_show', array('slug' => $supplier->getSlug()));
        }

        return array(
            'supplier' => $supplier,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Supplier entity.
     *
     * @Route("/admin/{slug}/edit", name="suppliers_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Supplier $supplier)
    {
        $editForm = $this->createForm(new SupplierType(), $supplier, array(
            'action' => $this->generateUrl('suppliers_update', array('slug' => $supplier->getSlug())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($supplier->getId(), 'suppliers_delete');

        return array(
            'supplier' => $supplier,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Supplier entity.
     *
     * @Route("/{slug}/update", name="suppliers_update")
     * @Method("PUT")
     * @Template("AppBundle:Supplier:edit.html.twig")
     */
    public function updateAction(Supplier $supplier, Request $request)
    {
        $editForm = $this->createForm(new SupplierType(), $supplier, array(
            'action' => $this->generateUrl('suppliers_update', array('slug' => $supplier->getSlug())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'gestock.edit.ok');
        }
        $deleteForm = $this->createDeleteForm($supplier->getId(), 'suppliers_delete');

        return array(
            'supplier' => $supplier,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Save order.
     *
     * @Route("/order/{field}/{type}", name="suppliers_sort")
     */
    public function sortAction($field, $type)
    {
        $this->setOrder('supplier', $field, $type);

        return $this->redirectToRoute('suppliers');
    }

    /**
     * Deletes a Supplier entity.
     *
     * @Route("/admin/{id}/delete", name="suppliers_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Supplier $supplier, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // Test if there is no articles with this supplier.
        $articles = $em->getRepository('AppBundle:Article')->getArticleFromSupplier($supplier);
        if (!empty($articles)) {
            $message = $this->get('translator')
                ->trans(
                    'delete.reassign_wrong',
                    array(),
                    'gs_suppliers'
                );
            $this->addFlash('danger', $message);
            return $this->redirectToRoute('articles_reassign', array('slug' => $supplier->getSlug()));
        }
        
        $form = $this->createDeleteForm($supplier->getId(), 'suppliers_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $supplier->setActive(false);
            $em->persist($supplier);
            $em->flush();
        }

        return $this->redirectToRoute('suppliers');
    }
}
