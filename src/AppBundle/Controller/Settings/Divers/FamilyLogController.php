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
 * @version GIT: <git_id>
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller\Settings\Divers;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AbstractController;
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
class FamilyLogController extends AbstractController
{
    /**
     * Lists all FamilyLog entities.
     *
     * @Route("/", name="familylog")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $return = $this->abstractIndexAction('FamilyLog', 'familylog', null);
        
        return $return;
    }

    /**
     * Finds and displays a FamilyLog entity.
     *
     * @Route("/{slug}/show", name="familylog_show")
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\FamilyLog $familylog FamilyLog item to display
     * @return array
     */
    public function showAction(FamilyLog $familylog)
    {
        $return = $this->abstractShowAction($familylog, 'familylog');

        return $return;
    }

    /**
     * Displays a form to create a new FamilyLog entity.
     *
     * @Route("/new", name="familylog_new")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'FamilyLog',
            'AppBundle\Entity\FamilyLog',
            FamilyLogType::class,
            'familylog'
        );

        return $return;
    }

    /**
     * Creates a new FamilyLog entity.
     *
     * @Route("/create", name="familylog_create")
     * @Method("POST")
     * @Template("AppBundle:FamilyLog:new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'Familylog',
            'AppBundle\Entity\FamilyLog',
            FamilyLogType::class,
            'familylog'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing FamilyLog entity.
     *
     * @Route("/{slug}/edit", name="familylog_edit")
     * @Method("GET")
     * @Template()
     *
     * @param \AppBunlde\Entity\FamilyLog $familylog FamilyLog item to edit
     * @return array
     */
    public function editAction(FamilyLog $familylog)
    {
        $return = $this->abstractEditAction(
            $familylog,
            'familylog',
            FamilyLogType::class
        );

        return $return;
    }

    /**
     * Edits an existing FamilyLog entity.
     *
     * @Route("/{slug}/update", name="familylog_update")
     * @Method("PUT")
     * @Template("AppBundle:FamilyLog:edit.html.twig")
     *
     * @param \AppBundle\Entity\FamilyLog               $familylog FamilyLog item to update
     * @param \Symfony\Component\HttpFoundation\Request $request   Form request
     * @return array
     */
    public function updateAction(FamilyLog $familylog, Request $request)
    {
        $return = $this->abstractUpdateAction(
            $familylog,
            $request,
            'familylog',
            FamilyLogType::class
        );

        return $return;
    }

    /**
     * Deletes a FamilyLog entity.
     *
     * @Route("/{id}/delete", name="familylog_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     *
     * @param \AppBundle\Entity\FamilyLog               $familylog FamilyLog item to delete
     * @param \Symfony\Component\HttpFoundation\Request $request   Form request
     * @return array
     */
    public function deleteAction(FamilyLog $familylog, Request $request)
    {
        $this->abstractDeleteAction(
            $familylog,
            $request,
            'familylog'
        );

        return $this->redirectToRoute('familylog');
    }
}
