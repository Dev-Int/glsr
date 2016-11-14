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
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Paginate|Sort request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $return = $this->abstractIndexAction('User', $request);
        
        return $return;
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}/show", name="user_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\User $user User item to display
     * @return array
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
     *
     * @return array
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'User',
            'AppBundle\Entity\User',
            UserType::class
        );

        return $return;
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/create", name="user_create")
     * @Method("POST")
     * @Template("AppBundle:User:new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $return = ['user' => $user, 'form'   => $form->createView(),];

        if ($form->handleRequest($request)->isValid()) {
            $group = $this->getDoctrine()->getManager()->getRepository('AppBundle:Group')->findBy(array('id' => $user->getGroup()));
            $user->setRoles($group->getRoles());
            $user->setEnabled(true);
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            $return = $this->redirectToRoute('user_show', ['id', $user->getId()]);
        }

        return $return;
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="user_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\User $user User item to edit
     * @return array
     */
    public function editAction(User $user)
    {
        $editForm = $this->createForm(UserType::class, $user, array(
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
     *
     * @param \AppBundle\Entity\User                    $user    User item to update
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(User $user, Request $request)
    {
        $editForm = $this->createForm(UserType::class, $user, array(
            'action' => $this->generateUrl('user_update', array('id' => $user->getId())),
            'method' => 'PUT',
            'passwordRequired' => false,
            'lockedRequired' => true
        ));
        $deleteForm = $this->createDeleteForm($user->getId(), 'user_delete');

        $return = ['user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),];

        if ($editForm->handleRequest($request)->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            $return = $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $return;
    }


    /**
     * Save order.
     *
     * @Route("/order/{entity}/{field}/{type}", name="user_sort")
     *
     * @param string $entity Entity of the field to sort
     * @param string $field  Field to sort
     * @param string $type   type of sort
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
     *
     * @param \AppBundle\Entity\User                    $user    User item to delete
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(User $user, Request $request)
    {
        $this->abstractDeleteAction($user, $request, 'user');

        return $this->redirectToRoute('user');
    }
}
