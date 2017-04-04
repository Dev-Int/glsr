<?php
/**
 * TvaController controller des taux de T.V.A.
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
use AppBundle\Entity\Tva;
use AppBundle\Form\Type\TvaType;

/**
 * Tva controller.
 *
 * @category Controller
 *
 * @Route("/admin/settings/divers/tva")
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
        $return = $this->abstractIndexAction('Tva', null);

        return $return;
    }

    /**
     * Finds and displays a Tva entity.
     *
     * @Route("/{id}/show", name="tva_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Tva $tva Tva item to display
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
            'Tva',
            'AppBundle\Entity\Tva',
            TvaType::class
        );

        return $return;
    }

    /**
     * Creates a new Tva entity.
     *
     * @Route("/create", name="tva_create")
     * @Method("POST")
     * @Template("AppBundle:Settings/Divers/Tva:new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'tva',
            'AppBundle\Entity\Tva',
            TvaType::class
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
     * @param \AppBundle\Entity\Tva $tva Tva item to edit
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
     * @Template("AppBundle:Settings/Divers/Tva:edit.html.twig")
     *
     * @param \AppBundle\Entity\Tva                     $tva     Tva item to update
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
     * @param \AppBundle\Entity\Tva                     $tva     Tva item to delete
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return type
     */
    public function deleteAction(Tva $tva, Request $request)
    {
        $this->abstractDeleteAction($tva, $request, 'tva');

        return $this->redirectToRoute('tva');
    }
}
