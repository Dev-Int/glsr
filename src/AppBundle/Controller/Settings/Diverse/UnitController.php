<?php
/**
 * UnitController controller des unités.
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
namespace AppBundle\Controller\Settings\Diverse;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Settings\Diverse\Unit;
use AppBundle\Form\Type\Settings\Diverse\UnitType;

/**
 * Unit controller.
 *
 * @category Controller
 *
 * @Route("/admin/settings/diverse/unit")
 */
class UnitController extends AbstractController
{
    /**
     * Lists all Unit entities.
     *
     * @Route("/", name="unit")
     * @Method("GET")
     * @Template()
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Paginate request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $return = $this->abstractIndexAction('Settings\Diverse\Unit', 'unit', $request);

        return $return;
    }

    /**
     * Finds and displays a Unit entity.
     *
     * @Route("/{slug}/show", name="unit_show")
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Settings\Diverse\Unit $unit UnitStaorage to display
     * @return array
     */
    public function showAction(Unit $unit)
    {
        $return = $this->abstractShowAction($unit, 'unit');

        return $return;
    }

    /**
     * Displays a form to create a new Unit entity.
     *
     * @Route("/new", name="unit_new")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'Settings\Diverse\Unit',
            'AppBundle\Entity\Settings\Diverse\Unit',
            UnitType::class,
            'unit'
        );

        return $return;
    }

    /**
     * Creates a new Unit entity.
     *
     * @Route("/create", name="unit_create")
     * @Method("POST")
     * @Template("AppBundle:Settings/Diverse/Unit:new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'Settings\Diverse\Unit',
            'AppBundle\Entity\Settings\Diverse\Unit',
            UnitType::class,
            'unit'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing Unit entity.
     *
     * @Route("/{slug}/edit", name="unit_edit")
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Settings\Diverse\Unit $unit Unit item to edit
     * @return array
     */
    public function editAction(Unit $unit)
    {
        $return = $this->abstractEditAction(
            $unit,
            'unit',
            UnitType::class
        );

        return $return;
    }

    /**
     * Edits an existing Unit entity.
     *
     * @Route("/{slug}/update", name="unit_update")
     * @Method("PUT")
     * @Template("AppBundle:Settings/Diverse/Unit:edit.html.twig")
     *
     * @param \AppBndle\Entity\Settings\Diverse\Unit $unit Unit item to update
     * @param \Symfony\Component\HttpFoundation\Request     $request     Form request
     * @return array
     */
    public function updateAction(Unit $unit, Request $request)
    {
        $return = $this->abstractUpdateAction(
            $unit,
            $request,
            'unit',
            UnitType::class
        );

        return $return;
    }

    /**
     * Deletes a Unit entity.
     *
     * @Route("/{id}/delete", name="unit_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     *
     * @param \AppBundle\Entity\Settings\Diverse\Unit   $unit    Unit item to delete
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function deleteAction(Unit $unit, Request $request)
    {
        $this->abstractDeleteAction($unit, $request, 'unit');

        return $this->redirectToRoute('unit');
    }
}
