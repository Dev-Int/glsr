<?php
/**
 * UnitStorageController controller des unités de stockage.
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
use AppBundle\Entity\UnitStorage;
use AppBundle\Form\Type\UnitStorageType;

/**
 * UnitStorage controller.
 *
 * @category Controller
 *
 * @Route("/admin/settings/divers/unitstorage")
 */
class UnitStorageController extends AbstractController
{
    /**
     * Lists all UnitStorage entities.
     *
     * @Route("/", name="unitstorage")
     * @Method("GET")
     * @Template()
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Paginate request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $return = $this->abstractIndexAction('UnitStorage', $request);

        return $return;
    }

    /**
     * Finds and displays a UnitStorage entity.
     *
     * @Route("/{slug}/show", name="unitstorage_show")
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\UnitStorage $unitstorage UnitStaorage to display
     * @return array
     */
    public function showAction(UnitStorage $unitstorage)
    {
        $return = $this->abstractShowAction($unitstorage, 'unitstorage');

        return $return;
    }

    /**
     * Displays a form to create a new UnitStorage entity.
     *
     * @Route("/new", name="unitstorage_new")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'UnitStorage',
            'AppBundle\Entity\UnitStorage',
            UnitStorageType::class
        );

        return $return;
    }

    /**
     * Creates a new UnitStorage entity.
     *
     * @Route("/create", name="unitstorage_create")
     * @Method("POST")
     * @Template("AppBundle:Settings/Divers/UnitStorage:new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'unitstorage',
            'AppBundle\Entity\UnitStorage',
            UnitStorageType::class
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing UnitStorage entity.
     *
     * @Route("/{slug}/edit", name="unitstorage_edit")
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\UnitStorage $unitstorage UnitStorage item to edit
     * @return array
     */
    public function editAction(UnitStorage $unitstorage)
    {
        $return = $this->abstractEditAction(
            $unitstorage,
            'unitstorage',
            UnitStorageType::class
        );

        return $return;
    }

    /**
     * Edits an existing UnitStorage entity.
     *
     * @Route("/{slug}/update", name="unitstorage_update")
     * @Method("PUT")
     * @Template("AppBundle:Settings/Divers/UnitStorage:edit.html.twig")
     *
     * @param \AppBndle\Entity\UnitStorage              $unitstorage UnitStorage item to update
     * @param \Symfony\Component\HttpFoundation\Request $request     Form request
     * @return array
     */
    public function updateAction(UnitStorage $unitstorage, Request $request)
    {
        $return = $this->abstractUpdateAction(
            $unitstorage,
            $request,
            'unitstorage',
            UnitStorageType::class
        );

        return $return;
    }

    /**
     * Deletes a UnitStorage entity.
     *
     * @Route("/{id}/delete", name="unitstorage_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     *
     * @param \AppBundle\Entity\UnitStorage             $unitstorage UnitStorage item to delete
     * @param \Symfony\Component\HttpFoundation\Request $request     Form request
     * @return array
     */
    public function deleteAction(UnitStorage $unitstorage, Request $request)
    {
        $this->abstractDeleteAction($unitstorage, $request, 'unitstorage');

        return $this->redirectToRoute('unitstorage');
    }
}
