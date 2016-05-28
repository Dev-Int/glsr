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
use AppBundle\Entity\UnitStorage;

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
     */
    public function indexAction(Request $request)
    {
        $etm = $this->getDoctrine()->getManager();
        $qbd = $etm->getRepository('AppBundle:UnitStorage')->createQueryBuilder('u');
        $paginator = $this->get('knp_paginator')->paginate($qbd, $request->query->get('page', 1), 20);
        return array(
            'paginator' => $paginator,
        );
    }

    /**
     * Finds and displays a UnitStorage entity.
     *
     * @Route("/{slug}/show", name="unitstorage_show")
     * @Method("GET")
     * @Template()
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
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'UnitStorage',
            'AppBundle\Entity\UnitStorage',
            'AppBundle\Form\Type\UnitStorageType'
        );

        return $return;
    }

    /**
     * Creates a new UnitStorage entity.
     *
     * @Route("/create", name="unitstorage_create")
     * @Method("POST")
     * @Template("AppBundle:Settings/Divers/UnitStorage:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'unitstorage',
            'AppBundle\Entity\UnitStorage',
            'AppBundle\Form\Type\UnitStorageType'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing UnitStorage entity.
     *
     * @Route("/{slug}/edit", name="unitstorage_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(UnitStorage $unitstorage)
    {
        $return = $this->abstractEditAction(
            $unitstorage,
            'unitstorage',
            'AppBundle\Form\Type\UnitStorageType'
        );

        return $return;
    }

    /**
     * Edits an existing UnitStorage entity.
     *
     * @Route("/{slug}/update", name="unitstorage_update")
     * @Method("PUT")
     * @Template("AppBundle:Settings/Divers/UnitStorage:edit.html.twig")
     */
    public function updateAction(UnitStorage $unitstorage, Request $request)
    {
        $return = $this->abstractUpdateAction(
            $unitstorage,
            $request,
            'unitstorage',
            'AppBundle\Form\Type\UnitStorageType'
        );

        return $return;
    }

    /**
     * Deletes a UnitStorage entity.
     *
     * @Route("/{id}/delete", name="unitstorage_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(UnitStorage $unitstorage, Request $request)
    {
        $this->abstractDeleteAction($unitstorage, $request, 'unitstorage');

        return $this->redirectToRoute('unitstorage');
    }
}
