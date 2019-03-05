<?php
/**
 * GroupController Controller of groups of users.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace App\Controller\Staff;

use App\Controller\AbstractAppController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Staff\Group;
use App\Form\Type\Staff\GroupType;

/**
 * Group controller.
 *
 * @category Controller
 *
 * @Route("/admin/group")
 */
class GroupController extends AbstractAppController
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
        $return = $this->abstractIndexAction('Staff\Group', 'group', null);

        return $return;
    }

    /**
     * Finds and displays a Group entity.
     *
     * @Route("/{id}/show", name="group_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \App\Entity\Staff\Group $group Group to display
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
            'Staff\Group',
            'App\Entity\Staff\Group',
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
     * @Template("staff/group/new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $name = filter_input(INPUT_POST, 'name');
        $roles = filter_input(INPUT_POST, 'roles');
        $group = new Group($name, $roles);
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
     * @param \App\Entity\Staff\Group $group Group item to edit
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
     * @Template("staff/group/edit.html.twig")
     *
     * @param \App\Entity\Staff\Group                   $group   Group item to update
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
     * @param \App\Entity\Staff\Group                   $group   Group item to delete
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
