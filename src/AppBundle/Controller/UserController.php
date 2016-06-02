<?php
/**
 * UserController controller des utilisateurs.
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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;

/**
 * User controller.
 *
 * @category Controller
 *
 * @Route("/admin/user")
 */
class UserController extends AbstractController
{
    /**
     * Lists all User entities.
     *
     * @Route("/", name="user")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $etm = $this->getDoctrine()->getManager();
        $qbd = $etm->getRepository('AppBundle:User')->getUsers();
        $this->addQueryBuilderSort($qbd, 'user');
        $paginator = $this->get('knp_paginator')->paginate($qbd, $request->query->get('page', 1), 5);
        
        return array(
            'paginator' => $paginator,
        );
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}/show", name="user_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(User $user)
    {
        $return = $this->abstractShowAction($user, 'user');

        return $return;
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="user_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'User',
            'AppBundle\Entity\User',
            'AppBundle\Form\Type\UserType'
        );

        return $return;
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/create", name="user_create")
     * @Method("POST")
     * @Template("AppBundle:User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        if ($form->handleRequest($request)->isValid()) {
            $user->setEnabled(true);
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            return $this->redirectToRoute('user_show', array('id', $user->getId()));
        }

        return array(
            'user' => $user,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="user_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(User $user)
    {
        $editForm = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('user_update', array('id' => $user->getId())),
            'method' => 'PUT',
            'passwordRequired' => false,
            'lockedRequired' => true
        ));
        $deleteForm = $this->createDeleteForm($user->getId(), 'user_delete');
 
        return array(
            'user' => $user,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}/update", name="user_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:User:edit.html.twig")
     */
    public function updateAction(User $user, Request $request)
    {
        $editForm = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('user_update', array('id' => $user->getId())),
            'method' => 'PUT',
            'passwordRequired' => false,
            'lockedRequired' => true
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }
        $deleteForm = $this->createDeleteForm($user->getId(), 'user_delete');

        return array(
            'user' => $user,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Save order.
     *
     * @Route("/order/{entity}/{field}/{type}", name="user_sort")
     */
    public function sortAction($entity, $field, $type)
    {
        $this->setOrder('user', $entity, $field, $type);

        return $this->redirectToRoute('user');
    }

    /**
     * Deletes a User entity.
     *
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     * @Route("/{id}/delete", name="user_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(User $user, Request $request)
    {
        $this->abstractDeleteAction($user, $request, 'user');

        return $this->redirectToRoute('user');
    }
}
