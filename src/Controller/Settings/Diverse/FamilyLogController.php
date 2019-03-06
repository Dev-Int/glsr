<?php
/**
 * FamilyLogController Controller of logistic families.
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
namespace App\Controller\Settings\Diverse;

use Symfony\Component\HttpFoundation\Request;
use App\Controller\AbstractAppController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Settings\Diverse\FamilyLog;
use App\Form\Type\Settings\Diverse\FamilyLogType;

/**
 * FamilyLog controller.
 *
 * @category Controller
 *
 * @Route("/admin/settings/diverse/familylog")
 */
class FamilyLogController extends AbstractAppController
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
        $return = $this->abstractIndexAction('Settings\Diverse\FamilyLog', 'familylog', null);
        
        return $return;
    }

    /**
     * Finds and displays a FamilyLog entity.
     *
     * @Route("/{slug}/show", name="familylog_show")
     * @Method("GET")
     * @Template()
     *
     * @param \App\Entity\Settings\Diverse\FamilyLog $familylog FamilyLog item to display
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
            'Settings\Diverse\FamilyLog',
            'App\Entity\Settings\Diverse\FamilyLog',
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
     * @Template("settings/diverse/family_log/new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'Settings\Diverse\Familylog',
            'App\Entity\Settings\Diverse\FamilyLog',
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
     * @param \AppBunlde\Entity\Settings\Diverse\FamilyLog $familylog FamilyLog item to edit
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
     * @Template("settings/diverse/family_log/edit.html.twig")
     *
     * @param \App\Entity\Settings\Diverse\FamilyLog    $familylog FamilyLog item to update
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
     * @param \App\Entity\Settings\Diverse\FamilyLog    $familylog FamilyLog item to delete
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
