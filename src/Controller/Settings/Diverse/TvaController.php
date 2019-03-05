<?php
/**
 * TvaController Controller of rates of T.V.A.
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
use App\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Settings\Diverse\Tva;
use App\Form\Type\Settings\Diverse\TvaType;

/**
 * Tva controller.
 *
 * @category Controller
 *
 * @Route("/admin/settings/diverse/tva")
 */
class TvaController extends AbstractController
{
    /**
     * Lists all Tva entities.
     *
     * @Route("/", name="tva")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $return = $this->abstractIndexAction('Settings\Diverse\Tva', 'tva', null);

        return $return;
    }

    /**
     * Finds and displays a Tva entity.
     *
     * @Route("/{id}/show", name="tva_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \App\Entity\Settings\Diverse\Tva $tva Tva item to display
     * @return array
     */
    public function showAction(Tva $tva)
    {
        $return = $this->abstractShowAction($tva, 'tva');

        return $return;
    }

    /**
     * Displays a form to create a new Tva entity.
     *
     * @Route("/new", name="tva_new")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'Settings\Diverse\Tva',
            'App\Entity\Settings\Diverse\Tva',
            TvaType::class,
            'tva'
        );

        return $return;
    }

    /**
     * Creates a new Tva entity.
     *
     * @Route("/create", name="tva_create")
     * @Method("POST")
     * @Template("settings/diverse/tva/new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'Settings\Diverse\Tva',
            'App\Entity\Settings\Diverse\Tva',
            TvaType::class,
            'tva'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing Tva entity.
     *
     * @Route("/{id}/edit", name="tva_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \App\Entity\Settings\Diverse\Tva $tva Tva item to edit
     * @return array
     */
    public function editAction(Tva $tva)
    {
        $return = $this->abstractEditAction($tva, 'tva', TvaType::class);

        return $return;
    }

    /**
     * Edits an existing Tva entity.
     *
     * @Route("/{id}/update", name="tva_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("settings/diverse/tva/edit.html.twig")
     *
     * @param \App\Entity\Settings\Diverse\Tva          $tva     Tva item to update
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function updateAction(Tva $tva, Request $request)
    {
        $return = $this->abstractUpdateAction($tva, $request, 'tva', TvaType::class);

        return $return;
    }

    /**
     * Deletes a Tva entity.
     *
     * @Route("/{id}/delete", name="tva_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     *
     * @param \App\Entity\Settings\Diverse\Tva          $tva     Tva item to delete
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return type
     */
    public function deleteAction(Tva $tva, Request $request)
    {
        $this->abstractDeleteAction($tva, $request, 'tva');

        return $this->redirectToRoute('tva');
    }
}
