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
 * @Route("/admin/groups")
 */
class GroupController extends AbstractController
{
    /**
     * Lists all Group entities.
     *
     * @Route("/", name="admin_groups")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Group')->findAll();
        
        return array('entities'  => $entities);
    }

    /**
     * Finds and displays a Group entity.
     *
     * @Route("/{id}/show", name="admin_groups_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Group $group)
    {
        $deleteForm = $this->createDeleteForm($group->getId(), 'admin_groups_delete');

        return array(
            'group' => $group,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Group entity.
     *
     * @Route("/new", name="admin_groups_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $group = new Group();
        $form = $this->createForm(new GroupType(), $group);
        $form->add('roles', 'choice', array(
            'choices' => $this->getExistingRoles(),
            'data' => $group->getRoles(),
            'label' => 'Roles',
            'translation_domain' => 'admin',
            'expanded' => true,
            'multiple' => true,
            'mapped' => true,
        ));


        return array(
            'group' => $group,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Group entity.
     *
     * @Route("/create", name="admin_groups_create")
     * @Method("POST")
     * @Template("AppBundle:Group:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $group = new Group();
        $form = $this->createForm(new GroupType(), $group);
        $form->add('roles', 'choice', array(
            'choices' => $this->getExistingRoles(),
            'data' => $group->getRoles(),
            'label' => 'Roles',
            'expanded' => true,
            'multiple' => true,
            'mapped' => true,
        ));
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute('admin_groups_show', array('id', $group->getId()));
        }

        return array(
            'group' => $group,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Group entity.
     *
     * @Route("/{id}/edit", name="admin_groups_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Group $group=null)
    {
        $editForm = $this->createForm(new GroupType(), $group, array(
            'action' => $this->generateUrl('admin_groups_update', array('id' => $group->getId())),
            'method' => 'PUT',
        ));
        $editForm->add('roles', 'choice', array(
            'choices' => $this->getExistingRoles(),
            'data' => $group->getRoles(),
            'label' => 'Roles',
            'expanded' => true,
            'multiple' => true,
            'mapped' => true,
        ));
        $deleteForm = $this->createDeleteForm($group->getId(), 'admin_groups_delete');

        return array(
            'group' => $group,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Group entity.
     *
     * @Route("/{id}/update", name="admin_groups_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Group:edit.html.twig")
     */
    public function updateAction(Request $request, Group $group=null)
    {
        $editForm = $this->createForm(new GroupType(), $group, array(
            'action' => $this->generateUrl('admin_groups_update', array('id' => $group->getId())),
            'method' => 'PUT',
        ));
        $editForm->add('roles', 'choice', array(
            'choices' => $this->getExistingRoles(),
            'data' => $group->getRoles(),
            'label' => 'Roles',
            'expanded' => true,
            'multiple' => true,
            'mapped' => true,
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_groups_edit', array('id' => $group->getId()));
        }
        $deleteForm = $this->createDeleteForm($group->getId(), 'admin_groups_delete');

        return array(
            'group' => $group,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Group entity.
     *
     * @Route("/{id}/delete", name="admin_groups_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Group $group=null)
    {
        $form = $this->createDeleteForm($group->getId(), 'admin_groups_delete');
        
        $em = $this->getDoctrine()->getManager();
        $users = $group->getUsers();
        foreach ($users as $user) {
            $user->getGroups()->removeElement($group);
        }
        $em->flush();

        $this->get('fos_user.group_manager')->deleteGroup($group);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($group);
            $em->flush();
        }

        return $this->redirectToRoute('admin_groups');
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
}
