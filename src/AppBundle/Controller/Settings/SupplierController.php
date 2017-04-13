<?php
/**
 * DefaultController controller des fournisseurs.
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
namespace AppBundle\Controller\Settings;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Settings\Supplier;
use AppBundle\Form\Type\Settings\SupplierType;

/**
 * Supplier controller.
 *
 * @category Controller
 *
 * @Route("/supplier")
 */
class SupplierController extends AbstractController
{
    /**
     * Lists all Supplier entities.
     *
     * @Route("/", name="supplier")
     * @Method("GET")
     * @Template()
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Paginate|Sort request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $return = $this->abstractIndexAction('Settings\Supplier', 'supplier', $request);
        
        return $return;
    }

    /**
     * Finds and displays a Supplier entity.
     *
     * @Route("/{slug}/show", name="supplier_show")
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Settings\Supplier $supplier Supplier item to display
     * @return array
     */
    public function showAction(Supplier $supplier)
    {
        $etm = $this->getDoctrine()->getManager();
        
        $deleteForm = $this->createDeleteForm($supplier->getId(), 'supplier_delete');

        // Récupérer les articles du fournisseur.
        $articles = $etm->getRepository('AppBundle:Settings\Article')->getArticleFromSupplier($supplier);
        return ['supplier' => $supplier, 'articles' => $articles, 'delete_form' => $deleteForm->createView(),];
    }

    /**
     * Displays a form to create a new Supplier entity.
     *
     * @Route("/admin/new", name="supplier_new")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'Settings\Supplier',
            'AppBundle\Entity\Settings\Supplier',
            SupplierType::class,
            'supplier'
        );

        return $return;
    }

    /**
     * Creates a new Supplier entity.
     *
     * @Route("/admin/create", name="supplier_create")
     * @Method("POST")
     * @Template("AppBundle:Settings/Supplier:new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'Settings\Supplier',
            'AppBundle\Entity\Settings\Supplier',
            SupplierType::class,
            'supplier'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing Supplier entity.
     *
     * @Route("/admin/{slug}/edit", name="supplier_edit")
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Settings\Supplier $supplier Supplier item to edit
     * @return array
     */
    public function editAction(Supplier $supplier)
    {
        $return = $this->abstractEditAction(
            $supplier,
            'supplier',
            SupplierType::class
        );

        return $return;
    }

    /**
     * Edits an existing Supplier entity.
     *
     * @Route("/{slug}/update", name="supplier_update")
     * @Method("PUT")
     * @Template("AppBundle:Settings/Supplier:edit.html.twig")
     *
     * @param \AppBundle\Entity\Settings\Supplier                $supplier Supplier item to update
     * @param \Symfony\Component\HttpFoundation\Request $request  Form request
     * @return array
     */
    public function updateAction(Supplier $supplier, Request $request)
    {
        $return = $this->abstractUpdateAction(
            $supplier,
            $request,
            'supplier',
            SupplierType::class
        );

        return $return;
    }


    /**
     * Save order.
     *
     * @Route("/order/{entity}/{field}/{type}", name="supplier_sort")
     *
     * @param string $entity Entity of the field to sort
     * @param string $field  Field to sort
     * @param string $type   type of sort
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sortAction($entity, $field, $type)
    {
        $this->get('app.helper.controller')->setOrder('article', $entity, $field, $type);

        return $this->redirectToRoute('supplier');
    }

    /**
     * Deletes a Supplier entity.
     *
     * @Route("/admin/{id}/delete", name="supplier_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     *
     * @param \AppBundle\Entity\Settings\Supplier                $supplier Supplier item to delete
     * @param \Symfony\Component\HttpFoundation\Request $request  Form request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Supplier $supplier, Request $request)
    {
        $etm = $this->getDoctrine()->getManager();
        // Test if there is no articles with this supplier.
        $articles = $etm->getRepository('AppBundle:Article')->getArticleFromSupplier($supplier);
        $this->abstractDeleteAction($supplier, $request, 'supplier');

        $return = $this->redirectToRoute('supplier');

        if (!empty($articles)) {
            $message = $this->get('translator')
                ->trans('delete.reassign_wrong', [], 'gs_suppliers');
            $this->addFlash('danger', $message);
            $return = $this->redirectToRoute('article_reassign', ['slug' => $supplier->getSlug()]);
        }

        return $return;
    }
}
