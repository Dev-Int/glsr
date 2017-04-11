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
 * @version GIT: <git_id>
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
        $return = $this->abstractIndexAction('Group', 'group', null);

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
        $return = $this->abstractNewAction(
            'Group',
            'AppBundle\Entity\Group',
            GroupType::class,
            'group'
        );

        return $return;
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
        $form = $this->createForm(GroupType::class, $group);
        AbstractController::addRolesAction($form, $group);
        $form->handleRequest($request);
        $return = ['group' => $group, 'form' => $form->createView(),];

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($group);
            $etm->flush();
            $this->addFlash('info', 'gestock.create.ok');

            $return = $this->redirectToRoute('group_show', array('id' => $group->getId()));
        }

        return $return;
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
        $return = $this->abstractEditAction($group, 'group', GroupType::class);

        return $return;
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
        $return = $this->abstractUpdateAction(
            $group,
            $request,
            'group',
            GroupType::class
        );

        return $return;
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
}
