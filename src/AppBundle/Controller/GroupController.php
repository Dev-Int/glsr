<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Group;
use AppBundle\Form\Type\GroupType;

/**
 * Group controller.
 *
 * @Route("/admin/groups")
 */
class GroupController extends Controller
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
        
        return array(
            'entities'  => $entities,
        );
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

            return $this->redirect(
                $this->generateUrl(
                    'admin_groups_show',
                    array('id' => $group->getId())
                )
            );
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
    public function editAction(Group $group)
    {
        $editForm = $this->createForm(
            new GroupType(),
            $group,
            array(
                'action' => $this->generateUrl(
                    'admin_groups_update',
                    array('id' => $group->getId())
                ),
                'method' => 'PUT',
            )
        );
        $editForm->add('roles', 'choice', array(
            'choices' => $this->getExistingRoles(),
            'data' => $group->getRoles(),
            'label' => 'Roles',
            'expanded' => true,
            'multiple' => true,
            'mapped' => true,
        ));
        $deleteForm = $this->createDeleteForm(
            $group->getId(),
            'admin_groups_delete'
        );

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
    public function updateAction(Group $group, Request $request)
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

            return $this->redirect($this->generateUrl('admin_groups_edit', array('id' => $group->getId())));
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
    public function deleteAction(Group $group, Request $request)
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

        return $this->redirect($this->generateUrl('admin_groups'));
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

    /**
     * Get the existing roles
     *
     * @return array Array of roles
     */
    private function getExistingRoles()
    {
        $roleHierarchy = $this->container->getParameter('security.role_hierarchy.roles');
        $roles = array_keys($roleHierarchy);

        foreach ($roles as $role) {
            $theRoles[$role] = $role;
        }
        return $theRoles;
    }
}
