<?php
/**
 * MterialController controller des matières.
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
namespace AppBundle\Controller\Config;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use AppBundle\Entity\Config\Material;
use AppBundle\Form\Type\Config\MaterialType;
use AppBundle\Entity\Article;

/**
 * Config\Material controller.
 *
 * @Route("/material")
 */
class MaterialController extends AbstractController
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
        $return = $this->abstractIndexAction('Config\Material', 'material', $request);

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
            'Config\Material',
            'AppBundle:Config\Material',
            MaterialType::class,
            'material'
        );
        $articles = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findAll();
        $return['articles'] = $articles;

        return $return;
    }

    /**
     * Creates a new Material entity.
     *
     * @Route("/admin/create", name="material_create")
     * @Method("POST")
     * @Template("AppBundle:Config\Material:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'Config\Material',
            'AppBundle:Config\Material',
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
        $articles = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findAll();
        $return['articles'] = $articles;

        return $return;
    }

    /**
     * Edits an existing Material entity.
     *
     * @Route("/admin/{slug}/update", name="material_update")
     * @Method("PUT")
     * @Template("AppBundle:Config\Material:edit.html.twig")
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
