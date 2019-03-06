<?php
/**
 * MterialController Controller of materials.
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

use App\Entity\Settings\Diverse\Material;
use App\Form\Type\Settings\Diverse\MaterialType;

/**
 * Material controller.
 *
 * @Route("/admin/settings/diverse/material")
 */
class MaterialController extends AbstractAppController
{
    /**
     * Lists all Material entities.
     *
     * @Route("/", name="material")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $return = $this->abstractIndexAction('Settings\Diverse\Material', 'material', $request);

        return $return;
    }

    /**
     * Finds and displays a Material entity.
     *
     * @Route("/{slug}/show", name="material_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Material $material)
    {
        $return = $this->abstractShowAction($material, 'material');

        return $return;
    }

    /**
     * Displays a form to create a new Material entity.
     *
     * @Route("/new", name="material_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'Settings\Diverse\Material',
            'App:Settings\Diverse\Material',
            MaterialType::class,
            'material'
        );
        $articles = $this->getDoctrine()->getManager()->getRepository('App:Settings\Article')->findAll();
        $return['articles'] = $articles;

        return $return;
    }

    /**
     * Creates a new Material entity.
     *
     * @Route("/admin/create", name="material_create")
     * @Method("POST")
     * @Template("settings/diverse/material/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'Settings\Diverse\Material',
            'App:Settings\Diverse\Material',
            MaterialType::class,
            'material'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing Material entity.
     *
     * @Route("/admin/{slug}/edit", name="material_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Material $material)
    {
        $return = $this->abstractEditAction($material, 'material', MaterialType::class);
        $articles = $this->getDoctrine()->getManager()->getRepository('App:Settings\Article')->findAll();
        $return['articles'] = $articles;

        return $return;
    }

    /**
     * Edits an existing Material entity.
     *
     * @Route("/admin/{slug}/update", name="material_update")
     * @Method("PUT")
     * @Template("settings/diverse/material/edit.html.twig")
     */
    public function updateAction(Material $material, Request $request)
    {
        $return = $this->abstractUpdateAction($material, $request, 'material', MaterialType::class);

        return $return;
    }

    /**
     * Save order.
     *
     * @Route("/order/{entity}/{field}/{type}", name="material_sort")
     *
     * @param string $entity Entity of the field to sort
     * @param string $field  Field to sort
     * @param string $type   type of sort
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sortAction($entity, $field, $type)
    {
        $this->get('app.helper.controller')->setOrder('material', $entity, $field, $type);

        return $this->redirect($this->generateUrl('material'));
    }

    /**
     * Deletes a Material entity.
     *
     * @Route("/{id}/delete", name="material_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Material $material, Request $request)
    {
        $this->abstractDeleteAction($material, $request, 'material');

        return $this->redirectToRoute('material');
    }
}
