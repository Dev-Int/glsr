<?php
/**
 * TvaController controller des taux de T.V.A.
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
use AppBundle\Entity\Tva;
use AppBundle\Form\Type\TvaType;

/**
 * Tva controller.
 *
 * @category Controller
 *
 * @Route("/admin/settings/divers/rate")
 */
class TvaController extends AbstractController
{
    /**
     * Lists all Tva entities.
     *
     * @Route("/", name="rate")
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
     * @Route("/{id}/show", name="rate_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Tva $tva)
    {
        $deleteForm = $this->createDeleteForm($tva->getId(), 'rate_delete');

        return array(
            'tva' => $tva,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Tva entity.
     *
     * @Route("/new", name="rate_new")
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
     * @Route("/create", name="rate_create")
     * @Method("POST")
     * @Template("AppBundle:Tva:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $url = '';
        $tva = new Tva();
        $form = $this->createForm(new TvaType(), $tva);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tva);
            $em->flush();

            if ($form->get('save')->isSubmitted()) {
                $url = $this->redirectToRoute('rate_show', array('id' => $tva->getId()));
            } elseif ($form->get('addmore')->isSubmitted()) {
                $this->addFlash('info', 'gestock.settings.add_ok');
                $url = $this->redirectToRoute('rate_new');
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
     * @Route("/{id}/edit", name="rate_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Tva $tva)
    {
        $editForm = $this->createForm(new TvaType(), $tva, array(
            'action' => $this->generateUrl('rate_update', array('id' => $tva->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($tva->getId(), 'rate_delete');

        return array(
            'tva' => $tva,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Tva entity.
     *
     * @Route("/{id}/update", name="rate_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Tva:edit.html.twig")
     */
    public function updateAction(Tva $tva, Request $request)
    {
        $editForm = $this->createForm(new TvaType(), $tva, array(
            'action' => $this->generateUrl('rate_update', array('id' => $tva->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'gestock.settings.edit_ok');

            return $this->redirectToRoute('rate_edit', array('id' => $tva->getId()));
        }
        $deleteForm = $this->createDeleteForm($tva->getId(), 'rate_delete');

        return array(
            'tva' => $tva,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Tva entity.
     *
     * @Route("/{id}/delete", name="rate_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Tva $tva, Request $request)
    {
        $form = $this->createDeleteForm($tva->getId(), 'rate_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tva);
            $em->flush();
        }

        return $this->redirectToRoute('rate');
    }
}
