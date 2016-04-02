<?php

namespace AppBundle\Controller\Settings;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Settings;
use AppBundle\Form\Type\SettingsType;

/**
 * Application controller.
 *
 * @category   Controller
 * @Route("/admin/settings/application")
 */
class ApplicationController extends Controller
{
    /**
     * Lists all Settings entities.
     *
     * @Route("/", name="admin_application")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Settings')->findAll();
        
        return array(
            'entities' => $entities,
            'ctEntity' => count($entities),
        );
    }

    /**
     * Finds and displays a Settings entity.
     *
     * @Route("/{id}/show", name="admin_application_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Settings $settings)
    {
        $deleteForm = $this->createDeleteForm($settings->getId(), 'admin_application_delete');

        return array(
            'settings' => $settings,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Settings entity.
     *
     * @Route("/new", name="admin_application_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $settings = new Settings();
        $form = $this->createForm(new SettingsType(), $settings);

        return array(
            'settings' => $settings,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Settings entity.
     *
     * @Route("/create", name="admin_application_create")
     * @Method("POST")
     * @Template("AppBundle:Application:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $settings = new Settings();
        $form = $this->createForm(new SettingsType(), $settings);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($settings);
            $em->flush();

            return $this->redirectToRoute('admin_application_show', array('id' => $settings->getId()));
        }

        return array(
            'settings' => $settings,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Settings entity.
     *
     * @Route("/{id}/edit", name="admin_application_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Settings $settings)
    {
        $editForm = $this->createForm(new SettingsType(), $settings, array(
            'action' => $this->generateUrl('admin_application_update', array('id' => $settings->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($settings->getId(), 'admin_application_delete');

        return array(
            'settings' => $settings,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Settings entity.
     *
     * @Route("/{id}/update", name="admin_application_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Application:edit.html.twig")
     */
    public function updateAction(Settings $settings, Request $request)
    {
        $editForm = $this->createForm(new SettingsType(), $settings, array(
            'action' => $this->generateUrl('admin_application_update', array('id' => $settings->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_application_edit', array('id' => $settings->getId()));
        }
        $deleteForm = $this->createDeleteForm($settings->getId(), 'admin_application_delete');

        return array(
            'settings' => $settings,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Settings entity.
     *
     * @Route("/{id}/delete", name="admin_application_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Settings $settings, Request $request)
    {
        $form = $this->createDeleteForm($settings->getId(), 'admin_application_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($settings);
            $em->flush();
        }

        return $this->redirectToRoute('admin_application');
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
