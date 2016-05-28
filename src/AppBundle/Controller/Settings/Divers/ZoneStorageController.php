<?php
/**
 * ZoneStorageController controller des zones de stockage.
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
namespace AppBundle\Controller\Settings\Divers;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\ZoneStorage;

/**
 * ZoneStorage controller.
 *
 * @category Controller
 *
 * @Route("/admin/settings/divers/zonestorage")
 */
class ZoneStorageController extends AbstractController
{
    /**
     * Lists all ZoneStorage entities.
     *
     * @Route("/", name="zonestorage")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $return = $this->abstractIndexAction('ZoneStorage');

        return $return;
    }

    /**
     * Finds and displays a ZoneStorage entity.
     *
     * @Route("/{slug}/show", name="zonestorage_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(ZoneStorage $zonestorage)
    {
        $return = $this->abstractShowAction($zonestorage, 'zonestorage');

        return $return;
    }

    /**
     * Displays a form to create a new ZoneStorage entity.
     *
     * @Route("/new", name="zonestorage_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'ZoneStorage',
            'AppBundle\Entity\ZoneStorage',
            'AppBundle\Form\Type\ZoneStorageType'
        );

        return $return;
    }

    /**
     * Creates a new ZoneStorage entity.
     *
     * @Route("/create", name="zonestorage_create")
     * @Method("POST")
     * @Template("AppBundle:Settings/Divers/ZoneStorage:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'zonestorage',
            'AppBundle\Entity\ZoneStorage',
            'AppBundle\Form\Type\ZoneStorageType'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing ZoneStorage entity.
     *
     * @Route("/{slug}/edit", name="zonestorage_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(ZoneStorage $zonestorage)
    {
        $return = $this->abstractEditAction(
            $zonestorage,
            'zonestorage',
            'AppBundle\Form\Type\ZoneStorageType'
        );

        return $return;
    }

    /**
     * Edits an existing ZoneStorage entity.
     *
     * @Route("/{slug}/update", name="zonestorage_update")
     * @Method("PUT")
     * @Template("AppBundle:Settings/Divers/ZoneStorage:edit.html.twig")
     */
    public function updateAction(ZoneStorage $zonestorage, Request $request)
    {
        $return = $this->abstractUpdateAction(
            $zonestorage,
            $request,
            'zonestorage',
            'AppBundle\Form\Type\ZoneStorageType'
        );

        return $return;
    }

    /**
     * Deletes a ZoneStorage entity.
     *
     * @Route("/{id}/delete", name="zonestorage_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(ZoneStorage $zonestorage, Request $request)
    {
        $this->abstractDeleteAction($zonestorage, $request, 'zonestorage');

        return $this->redirectToRoute('zonestorage');
    }
}
