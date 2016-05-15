<?php
/**
 * UnitStorageController controller des unités de stockage.
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
namespace AppBundle\Controller\Settings\Divers;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\UnitStorage;
use AppBundle\Form\Type\UnitStorageType;

/**
 * UnitStorage controller.
 *
 * @category Controller
 *
 * @Route("/admin/settings/divers/unitstorage")
 */
class UnitStorageController extends AbstractController
{
    /**
     * Lists all UnitStorage entities.
     *
     * @Route("/", name="unitstorage")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:UnitStorage')->createQueryBuilder('u');
        $paginator = $this->get('knp_paginator')->paginate($qb, $request->query->get('page', 1), 20);
        return array(
            'paginator' => $paginator,
        );
    }

    /**
     * Finds and displays a UnitStorage entity.
     *
     * @Route("/{slug}/show", name="unitstorage_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(UnitStorage $unitstorage)
    {
        $deleteForm = $this->createDeleteForm($unitstorage->getId(), 'unitstorage_delete');

        return array(
            'unitstorage' => $unitstorage,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new UnitStorage entity.
     *
     * @Route("/new", name="unitstorage_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $unitstorage = new UnitStorage();
        $form = $this->createForm(new UnitStorageType(), $unitstorage);

        return array(
            'unitstorage' => $unitstorage,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new UnitStorage entity.
     *
     * @Route("/create", name="unitstorage_create")
     * @Method("POST")
     * @Template("AppBundle:Settings/Divers/UnitStorage:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $url = '';
        $unitstorage = new UnitStorage();
        $form = $this->createForm(new UnitStorageType(), $unitstorage);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unitstorage);
            $em->flush();

            if ($form->get('save')->isSubmitted()) {
                $url = $this->redirectToRoute('unitstorage_show', array('slug' => $unitstorage->getSlug()));
            } elseif ($form->get('addmore')->isSubmitted()) {
                $this->addFlash('info', 'gestock.settings.add_ok');
                $url = $this->redirectToRoute('unitstorage_new');
            }
            return $url;
        }

        return array(
            'unitstorage' => $unitstorage,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing UnitStorage entity.
     *
     * @Route("/{slug}/edit", name="unitstorage_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(UnitStorage $unitstorage)
    {
        $editForm = $this->createForm(new UnitStorageType(), $unitstorage, array(
            'action' => $this->generateUrl('unitstorage_update', array('slug' => $unitstorage->getSlug())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($unitstorage->getId(), 'unitstorage_delete');

        return array(
            'unitstorage' => $unitstorage,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing UnitStorage entity.
     *
     * @Route("/{slug}/update", name="unitstorage_update")
     * @Method("PUT")
     * @Template("AppBundle:Settings/Divers/UnitStorage:edit.html.twig")
     */
    public function updateAction(UnitStorage $unitstorage, Request $request)
    {
        $editForm = $this->createForm(new UnitStorageType(), $unitstorage, array(
            'action' => $this->generateUrl('unitstorage_update', array('slug' => $unitstorage->getSlug())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'gestock.settings.edit_ok');

            return $this->redirectToRoute('unitstorage_edit', array('slug' => $unitstorage->getSlug()));
        }
        $deleteForm = $this->createDeleteForm($unitstorage->getId(), 'unitstorage_delete');

        return array(
            'unitstorage' => $unitstorage,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a UnitStorage entity.
     *
     * @Route("/{id}/delete", name="unitstorage_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(UnitStorage $unitstorage, Request $request)
    {
        $form = $this->createDeleteForm($unitstorage->getId(), 'unitstorage_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($unitstorage);
            $em->flush();
        }

        return $this->redirectToRoute('unitstorage');
    }
}
