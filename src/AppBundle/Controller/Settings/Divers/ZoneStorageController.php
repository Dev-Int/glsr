<?php

namespace AppBundle\Controller\Settings\Divers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\ZoneStorage;
use AppBundle\Form\Type\ZoneStorageType;

/**
 * ZoneStorage controller.
 *
 * @Route("/admin/settings/divers/zonestorage")
 */
class ZoneStorageController extends Controller
{
    /**
     * Lists all ZoneStorage entities.
     *
     * @Route("/", name="admin_zonestorage")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:ZoneStorage')->findAll();
        
        return array(
            'entities'  => $entities,
        );
    }

    /**
     * Finds and displays a ZoneStorage entity.
     *
     * @Route("/{slug}/show", name="admin_zonestorage_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(ZoneStorage $zonestorage)
    {
        $deleteForm = $this->createDeleteForm($zonestorage->getId(), 'admin_zonestorage_delete');

        return array(
            'zonestorage' => $zonestorage,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new ZoneStorage entity.
     *
     * @Route("/new", name="admin_zonestorage_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $zonestorage = new ZoneStorage();
        $form = $this->createForm(new ZoneStorageType(), $zonestorage);

        return array(
            'zonestorage' => $zonestorage,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new ZoneStorage entity.
     *
     * @Route("/create", name="admin_zonestorage_create")
     * @Method("POST")
     * @Template("AppBundle:Settings/Divers/ZoneStorage:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $zonestorage = new ZoneStorage();
        $form = $this->createForm(new ZoneStorageType(), $zonestorage);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($zonestorage);
            $em->flush();

            if ($form->get('save')->isClicked()) {
                $url = $this->redirectToRoute('admin_zonestorage_show', array('slug' => $zonestorage->getSlug()));
            } elseif ($form->get('addmore')->isClicked()) {
                $this->addFlash('info', 'gestock.settings.add_ok');
                $url = $this->redirect($this->generateUrl('admin_zonestorage_new'));
            }
            return $url;
        }

        return array(
            'zonestorage' => $zonestorage,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ZoneStorage entity.
     *
     * @Route("/{slug}/edit", name="admin_zonestorage_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(ZoneStorage $zonestorage)
    {
        $editForm = $this->createForm(new ZoneStorageType(), $zonestorage, array(
            'action' => $this->generateUrl('admin_zonestorage_update', array('slug' => $zonestorage->getSlug())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($zonestorage->getId(), 'admin_zonestorage_delete');

        return array(
            'zonestorage' => $zonestorage,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ZoneStorage entity.
     *
     * @Route("/{slug}/update", name="admin_zonestorage_update")
     * @Method("PUT")
     * @Template("AppBundle:Settings/Divers/ZoneStorage:edit.html.twig")
     */
    public function updateAction(ZoneStorage $zonestorage, Request $request)
    {
        $editForm = $this->createForm(new ZoneStorageType(), $zonestorage, array(
            'action' => $this->generateUrl('admin_zonestorage_update', array('slug' => $zonestorage->getSlug())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_zonestorage_edit', array('slug' => $zonestorage->getSlug()));
        }
        $deleteForm = $this->createDeleteForm($zonestorage->getId(), 'admin_zonestorage_delete');

        return array(
            'zonestorage' => $zonestorage,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ZoneStorage entity.
     *
     * @Route("/{id}/delete", name="admin_zonestorage_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(ZoneStorage $zonestorage, Request $request)
    {
        $form = $this->createDeleteForm($zonestorage->getId(), 'admin_zonestorage_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($zonestorage);
            $em->flush();
        }

        return $this->redirectToRoute('admin_zonestorage');
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
