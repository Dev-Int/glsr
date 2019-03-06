<?php
/**
 * ZoneStorageController controller des zones de stockage.
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
use App\Entity\Settings\Diverse\ZoneStorage;
use App\Form\Type\Settings\Diverse\ZoneStorageType;

/**
 * ZoneStorage controller.
 *
 * @category Controller
 *
 * @Route("/admin/settings/diverse/zonestorage")
 */
class ZoneStorageController extends AbstractAppController
{
    /**
     * Lists all ZoneStorage entities.
     *
     * @Route("/", name="zonestorage")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $return = $this->abstractIndexAction('Settings\Diverse\ZoneStorage', 'zonestorage', null);

        return $return;
    }

    /**
     * Finds and displays a ZoneStorage entity.
     *
     * @Route("/{slug}/show", name="zonestorage_show")
     * @Method("GET")
     * @Template()
     *
     * @param \App\Entity\Settings\Diverse\ZoneStorage $zonestorage ZoneStorage to display
     * @return array
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
     *
     * @return array
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'ZoneStorage',
            'App\Entity\Settings\Diverse\ZoneStorage',
            ZoneStorageType::class,
            'zonestorage'
        );

        return $return;
    }

    /**
     * Creates a new ZoneStorage entity.
     *
     * @Route("/create", name="zonestorage_create")
     * @Method("POST")
     * @Template("settings/diverse/zone_storage/new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'Settings\Diverse\Zonestorage',
            'App\Entity\Settings\Diverse\ZoneStorage',
            ZoneStorageType::class,
            'zonestorage'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing ZoneStorage entity.
     *
     * @Route("/{slug}/edit", name="zonestorage_edit")
     * @Method("GET")
     * @Template()
     *
     * @param \App\Entity\Settings\Diverse\ZoneStorage $zonestorage ZoneStorage item to edit
     * @return array
     */
    public function editAction(ZoneStorage $zonestorage)
    {
        $return = $this->abstractEditAction(
            $zonestorage,
            'zonestorage',
            ZoneStorageType::class
        );

        return $return;
    }

    /**
     * Edits an existing ZoneStorage entity.
     *
     * @Route("/{slug}/update", name="zonestorage_update")
     * @Method("PUT")
     * @Template("settings/diverse/zone_storage/edit.html.twig")
     *
     * @param \App\Entity\Settings\Diverse\ZoneStorage $zonestorage ZoneStorage item to update
     * @param \Symfony\Component\HttpFoundation\Request      $request     Form request
     * @return array
     */
    public function updateAction(ZoneStorage $zonestorage, Request $request)
    {
        $return = $this->abstractUpdateAction(
            $zonestorage,
            $request,
            'zonestorage',
            ZoneStorageType::class
        );

        return $return;
    }

    /**
     * Deletes a ZoneStorage entity.
     *
     * @Route("/{id}/delete", name="zonestorage_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     *
     * @param \App\Entity\Settings\Diverse\ZoneStorage $zonestorage ZoneStorage item to delete
     * @param \Symfony\Component\HttpFoundation\Request      $request     Form request
     * @return array
     */
    public function deleteAction(ZoneStorage $zonestorage, Request $request)
    {
        $this->abstractDeleteAction($zonestorage, $request, 'zonestorage');

        return $this->redirectToRoute('zonestorage');
    }
}
