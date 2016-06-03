<?php
/**
 * GroupController controller des groupes d'utilisateurs.
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
use AppBundle\Entity\Group;
use AppBundle\Form\Type\GroupType;

/**
 * Group controller.
 *
 * @category Controller
 *
 * @Route("/admin/group")
 */
class GroupController extends AbstractController
{
    /**
     * Lists all Group entities.
     *
     * @Route("/", name="group")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $return = $this->abstractIndexAction('Group');

        return $return;
    }

    /**
     * Finds and displays a Group entity.
     *
     * @Route("/{id}/show", name="group_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Group $group Group to display
     * @return array
     */
    public function showAction(Group $group)
    {
        $return = $this->abstractShowAction($group, 'group');

        return $return;
    }

    /**
     * Displays a form to create a new Group entity.
     *
     * @Route("/new", name="group_new")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function newAction()
    {
        $group = new Group();
        $form = $this->createForm(new GroupType(), $group);
        $this->addRoles($form, $group);

        return array(
            'group' => $group,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Group entity.
     *
     * @Route("/create", name="group_create")
     * @Method("POST")
     * @Template("AppBundle:Group:new.html.twig")
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $group = new Group();
        $form = $this->createForm(new GroupType(), $group);
        $this->addRoles($form, $group);

        if ($form->handleRequest($request)->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($group);
            $etm->flush();
            $this->addFlash('info', 'gestock.create.ok');

            return $this->redirectToRoute('group_show', array('id' => $group->getId()));
        }

        return array(
            'group' => $group,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Group entity.
     *
     * @Route("/{id}/edit", name="group_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Group $group Group item to edit
     * @return array
     */
    public function editAction(Group $group)
    {
        $editForm = $this->createForm(new GroupType(), $group, array(
            'action' => $this->generateUrl('group_update', array('id' => $group->getId())),
            'method' => 'PUT',
        ));
        $this->addRoles($editForm, $group);

        $deleteForm = $this->createDeleteForm($group->getId(), 'group_delete');

        return array(
            'group' => $group,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Group entity.
     *
     * @Route("/{id}/update", name="group_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Group:edit.html.twig")
     *
     * @param \AppBundle\Entity\Group                   $group   Group item to update
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function updateAction(Group $group, Request $request)
    {
        $editForm = $this->createForm(new GroupType(), $group, array(
            'action' => $this->generateUrl('group_update', array('id' => $group->getId())),
            'method' => 'PUT',
        ));
        $this->addRoles($editForm, $group);

        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'gestock.edit.ok');

            return $this->redirectToRoute('group_edit', array('id' => $group->getId()));
        }
        $deleteForm = $this->createDeleteForm($group->getId(), 'group_delete');

        return array(
            'group' => $group,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Group entity.
     *
     * @Route("/{id}/delete", name="group_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     *
     * @param \AppBundle\Entity\Group                   $group   Group item to delete
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Group $group, Request $request)
    {
        $form = $this->createDeleteForm($group->getId(), 'group_delete');
        
        $etm = $this->getDoctrine()->getManager();
        $users = $group->getUsers();
        foreach ($users as $user) {
            $user->getGroups()->removeElement($group);
        }
        $etm->flush();

        $this->get('fos_user.group_manager')->deleteGroup($group);

        if ($form->handleRequest($request)->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->remove($group);
            $etm->flush();
        }

        return $this->redirectToRoute('group');
    }

    /**
     * Get the existing roles
     *
     * @return array Array of roles
     */
    private function getExistingRoles()
    {
        $roleHierarchy = $this->container->getParameter('security.role_hierarchy.roles');
        $roles = array_keys($roleHierarchy);
        $theRoles = array();

        foreach ($roles as $role) {
            $theRoles[$role] = $role;
        }
        return $theRoles;
    }

    /**
     * Add roles to form
     *
     * @param \Symfony\Component\Form\Form  $form  The form in which to insert the roles
     * @param \AppBundle\Entity\Group       $group The entity to deal
     * @return \Symfony\Component\Form\Form The form
     */
    private function addRoles($form, $group)
    {
        $form->add('roles', 'choice', array(
            'choices' => $this->getExistingRoles(),
            'data' => $group->getRoles(),
            'label' => 'Roles',
            'expanded' => true,
            'multiple' => true,
            'mapped' => true,
        ));

        return $form;
    }
}
