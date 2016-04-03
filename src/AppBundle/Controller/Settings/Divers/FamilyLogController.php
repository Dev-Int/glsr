<?php
/**
 * FamilyLogController controller des familles logistiques.
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
namespace AppBundle\Controller\Settings\Divers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\FamilyLog;
use AppBundle\Form\Type\FamilyLogType;

/**
 * FamilyLog controller.
 *
 * @category Controller
 *
 * @Route("/admin/settings/divers/familylog")
 */
class FamilyLogController extends Controller
{
    /**
     * Lists all FamilyLog entities.
     *
     * @Route("/", name="admin_familylog")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:FamilyLog')->findAll();
        
        return array(
            'entities'  => $entities,
        );
    }

    /**
     * Finds and displays a FamilyLog entity.
     *
     * @Route("/{slug}/show", name="admin_familylog_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(FamilyLog $familylog)
    {
        $deleteForm = $this->createDeleteForm($familylog->getId(), 'admin_familylog_delete');

        return array(
            'familylog' => $familylog,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new FamilyLog entity.
     *
     * @Route("/new", name="admin_familylog_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $familylog = new FamilyLog();
        $form = $this->createForm(new FamilyLogType(), $familylog);

        return array(
            'familylog' => $familylog,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new FamilyLog entity.
     *
     * @Route("/create", name="admin_familylog_create")
     * @Method("POST")
     * @Template("AppBundle:FamilyLog:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $familylog = new FamilyLog();
        $form = $this->createForm(new FamilyLogType(), $familylog);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($familylog);
            $em->flush();

            if ($form->get('save')->isClicked()) {
                $url = $this->redirect($this->generateUrl(
                    'admin_familylog_show',
                    array('slug' => $familylog->getSlug())
                ));
            } elseif ($form->get('addmore')->isClicked()) {
                $this->addFlash('info', 'gestock.settings.add_ok');
                $url = $this->redirectToRoute('admin_familylog_new');
            }
            return $url;
        }

        return array(
            'familylog' => $familylog,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing FamilyLog entity.
     *
     * @Route("/{slug}/edit", name="admin_familylog_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(FamilyLog $familylog)
    {
        $editForm = $this->createForm(new FamilyLogType(), $familylog, array(
            'action' => $this->generateUrl(
                'admin_familylog_update',
                array('slug' => $familylog->getSlug())
            ),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($familylog->getId(), 'admin_familylog_delete');

        return array(
            'familylog' => $familylog,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing FamilyLog entity.
     *
     * @Route("/{slug}/update", name="admin_familylog_update")
     * @Method("PUT")
     * @Template("AppBundle:FamilyLog:edit.html.twig")
     */
    public function updateAction(FamilyLog $famlog, Request $request)
    {
        $editForm = $this->createForm(new FamilyLogType(), $famlog, array(
            'action' => $this->generateUrl(
                'admin_familylog_update',
                array('slug' => $famlog->getSlug())
            ),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_familylog_edit', array('slug' => $famlog->getSlug()));
        }
        $deleteForm = $this->createDeleteForm($famlog->getId(), 'admin_familylog_delete');

        return array(
            'familylog' => $famlog,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a FamilyLog entity.
     *
     * @Route("/{id}/delete", name="admin_familylog_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(FamilyLog $familylog, Request $request)
    {
        $form = $this->createDeleteForm($familylog->getId(), 'admin_familylog_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($familylog);
            $em->flush();
        }

        return $this->redirectToRoute('admin_familylog');
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
