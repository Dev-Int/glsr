<?php

namespace AppBundle\Controller\Settings\Divers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Tva;
use AppBundle\Form\Type\TvaType;

/**
 * Tva controller.
 *
 * @Route("/admin/settings/divers/rate")
 */
class TvaController extends Controller
{
    /**
     * Lists all Tva entities.
     *
     * @Route("/", name="admin_rate")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Tva')->findAll();
        
        return array(
            'entities'  => $entities,
        );
    }

    /**
     * Finds and displays a Tva entity.
     *
     * @Route("/{id}/show", name="admin_rate_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Tva $tva)
    {
        $deleteForm = $this->createDeleteForm($tva->getId(), 'admin_rate_delete');

        return array(
            'tva' => $tva,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Tva entity.
     *
     * @Route("/new", name="admin_rate_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $tva = new Tva();
        $form = $this->createForm(new TvaType(), $tva);

        return array(
            'tva' => $tva,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Tva entity.
     *
     * @Route("/create", name="admin_rate_create")
     * @Method("POST")
     * @Template("AppBundle:Tva:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $tva = new Tva();
        $form = $this->createForm(new TvaType(), $tva);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tva);
            $em->flush();

            if ($form->get('save')->isClicked()) {
                $url = $this->redirectToRoute('admin_rate_show', array('id' => $tva->getId()));
            } elseif ($form->get('addmore')->isClicked()) {
                $this->addFlash('info', 'gestock.settings.add_ok');
                $url = $this->redirectToRoute('admin_rate_new');
            }
            return $url;
        }

        return array(
            'tva' => $tva,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Tva entity.
     *
     * @Route("/{id}/edit", name="admin_rate_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Tva $tva)
    {
        $editForm = $this->createForm(new TvaType(), $tva, array(
            'action' => $this->generateUrl('admin_rate_update', array('id' => $tva->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($tva->getId(), 'admin_rate_delete');

        return array(
            'tva' => $tva,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Tva entity.
     *
     * @Route("/{id}/update", name="admin_rate_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Tva:edit.html.twig")
     */
    public function updateAction(Tva $tva, Request $request)
    {
        $editForm = $this->createForm(new TvaType(), $tva, array(
            'action' => $this->generateUrl('admin_rate_update', array('id' => $tva->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_rate_edit', array('id' => $tva->getId()));
        }
        $deleteForm = $this->createDeleteForm($tva->getId(), 'admin_rate_delete');

        return array(
            'tva' => $tva,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Tva entity.
     *
     * @Route("/{id}/delete", name="admin_rate_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Tva $tva, Request $request)
    {
        $form = $this->createDeleteForm($tva->getId(), 'admin_rate_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tva);
            $em->flush();
        }

        return $this->redirectToRoute('admin_rate');
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
