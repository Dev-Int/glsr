<?php
/**
 * ApplicationController controller de configuration de l'application.
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
namespace AppBundle\Controller\Settings;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Settings;
use AppBundle\Form\Type\SettingsType;

/**
 * Application controller.
 *
 * @category   Controller
 *
 * @Route("/admin/settings/application")
 */
class ApplicationController extends AbstractController
{
    /**
     * Lists all Settings entities.
     *
     * @Route("/", name="application")
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
     * @Route("/{id}/show", name="application_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Settings $settings)
    {
        $deleteForm = $this->createDeleteForm($settings->getId(), 'application_delete');

        return array(
            'settings' => $settings,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Settings entity.
     *
     * @Route("/new", name="application_new")
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
     * @Route("/create", name="application_create")
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

            return $this->redirectToRoute('application_show', array('id' => $settings->getId()));
        }

        return array(
            'settings' => $settings,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Settings entity.
     *
     * @Route("/{id}/edit", name="application_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Settings $settings)
    {
        $editForm = $this->createForm(new SettingsType(), $settings, array(
            'action' => $this->generateUrl('application_update', array('id' => $settings->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($settings->getId(), 'application_delete');

        return array(
            'settings' => $settings,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Settings entity.
     *
     * @Route("/{id}/update", name="application_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Application:edit.html.twig")
     */
    public function updateAction(Settings $settings, Request $request)
    {
        $editForm = $this->createForm(new SettingsType(), $settings, array(
            'action' => $this->generateUrl('application_update', array('id' => $settings->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'gestock.settings.edit_ok');

            return $this->redirectToRoute('application_edit', array('id' => $settings->getId()));
        }
        $deleteForm = $this->createDeleteForm($settings->getId(), 'application_delete');

        return array(
            'settings' => $settings,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Settings entity.
     *
     * @Route("/{id}/delete", name="application_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Settings $settings, Request $request)
    {
        $form = $this->createDeleteForm($settings->getId(), 'application_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($settings);
            $em->flush();
        }

        return $this->redirectToRoute('application');
    }
}
