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
     */
    public function indexAction()
    {
        $return = $this->abstractIndexAction('Tva');

        return $return;
    }

    /**
     * Finds and displays a Tva entity.
     *
     * @Route("/{id}/show", name="tva_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
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
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'Tva',
            'AppBundle\Entity\Tva',
            'AppBundle\Form\Type\TvaType'
        );

        return $return;
    }

    /**
     * Creates a new Tva entity.
     *
     * @Route("/create", name="tva_create")
     * @Method("POST")
     * @Template("AppBundle:Tva:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'tva',
            'AppBundle\Entity\Tva',
            'AppBundle\Form\Type\TvaType'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing Tva entity.
     *
     * @Route("/{id}/edit", name="tva_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Tva $tva)
    {
        $return = $this->abstractEditAction($tva, 'tva', 'AppBundle\Form\Type\TvaType');

        return $return;
    }

    /**
     * Edits an existing Tva entity.
     *
     * @Route("/{id}/update", name="tva_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Tva:edit.html.twig")
     */
    public function updateAction(Tva $tva, Request $request)
    {
        $return = $this->abstractUpdateAction($tva, $request, 'tva', 'AppBundle\Form\Type\TvaType');

        return $return;
   }

    /**
     * Deletes a Tva entity.
     *
     * @Route("/{id}/delete", name="tva_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Tva $tva, Request $request)
    {
        $this->abstractDeleteAction($tva, $request, 'tva');
//        $form = $this->createDeleteForm($tva->getId(), 'tva_delete');
//        if ($form->handleRequest($request)->isValid()) {
//            $etm = $this->getDoctrine()->getManager();
//            $etm->remove($tva);
//            $etm->flush();
//        }

        return $this->redirectToRoute('tva');
    }
}
