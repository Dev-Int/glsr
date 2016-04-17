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
use Symfony\Component\Translation\Translator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\QueryBuilder;
use AppBundle\Entity\Supplier;
use AppBundle\Form\Type\SupplierType;

/**
 * Supplier controller.
 *
 * @category Controller
 *
 * @Route("/suppliers")
 */
class SupplierController extends Controller
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
        $qb = $em->getRepository('AppBundle:Supplier')->createQueryBuilder('s');
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
        $deleteForm = $this->createDeleteForm($supplier->getId(), 'suppliers_delete');

        return array(
            'supplier' => $supplier,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Supplier entity.
     *
     * @Route("/new", name="suppliers_new")
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
     * @Route("/{slug}/edit", name="suppliers_edit")
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
     * @param string $name  session name
     * @param string $field field name
     * @param string $type  sort type ("ASC"/"DESC")
     */
    protected function setOrder($name, $field, $type = 'ASC')
    {
        $this->getRequest()->getSession()->set('sort.' . $name, array('field' => $field, 'type' => $type));
    }

    /**
     * @param  string $name
     * @return array
     */
    protected function getOrder($name)
    {
        $session = $this->getRequest()->getSession();

        return $session->has('sort.' . $name) ? $session->get('sort.' . $name) : null;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $name
     */
    protected function addQueryBuilderSort(QueryBuilder $qb, $name)
    {
        $alias = current($qb->getDQLPart('from'))->getAlias();
        if (is_array($order = $this->getOrder($name))) {
            $qb->orderBy($alias . '.' . $order['field'], $order['type']);
        }
    }

    /**
     * Deletes a Supplier entity.
     *
     * @Route("/{id}/delete", name="suppliers_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Supplier $supplier, Request $request)
    {
        $form = $this->createDeleteForm($supplier->getId(), 'suppliers_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($supplier);
            $em->flush();
        }

        return $this->redirectToRoute('suppliers');
    }

    /**
     * Create Delete form
     *
     * @param integer                       $id
     * @param string                        $route
     * @return \Symfony\Component\Form\Form
     */
    protected function createDeleteForm($id, $route)
    {
        return $this->createFormBuilder(null, array('attr' => array('id' => 'delete')))
            ->setAction($this->generateUrl($route, array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
