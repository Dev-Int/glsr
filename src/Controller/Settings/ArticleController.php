<?php
/**
 * ArticleController Controller of articles.
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
namespace App\Controller\Settings;

use App\Controller\AbstractAppController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Settings\Article;
use App\Entity\Settings\Supplier;
use App\Form\Type\Settings\ArticleType;
use App\Form\Type\Settings\ArticleReassignType;

/**
 * Article controller.
 *
 * @category Controller
 *
 * @Route("/article")
 */
class ArticleController extends AbstractAppController
{
    /**
     * Lists all Article entities.
     *
     * @Route("/", name="article")
     * @Method("GET")
     * @Template()
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Paginate request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $return = $this->abstractIndexAction('Settings\Article', 'article', $request);
        
        return $return;
    }

    /**
     * Finds and displays a Article entity.
     *
     * @Route("/{slug}/show", name="article_show")
     * @Method("GET")
     * @Template()
     *
     * @param \App\Entity\Settings\Article $article Article item to display
     * @return array
     */
    public function showAction(Article $article)
    {
        $return = $this->abstractShowAction($article, 'article');

        return $return;
    }

    /**
     * Displays a form to create a new Article entity.
     *
     * @Route("/admin/new", name="article_new")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function newAction()
    {
        $return = $this->abstractNewAction(
            'Settings\Article',
            'App\Entity\Settings\Article',
            ArticleType::class,
            'article'
        );

        return $return;
    }

    /**
     * Creates a new Article entity.
     *
     * @Route("/admin/create", name="article_create")
     * @Method("POST")
     * @Template("settings\article/new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'Settings\Article',
            'App\Entity\Settings\Article',
            ArticleType::class,
            'article'
        );

        return $return;
    }

    /**
     * Displays a form to edit an existing Article entity.
     *
     * @Route("/admin/{slug}/edit", name="article_edit")
     * @Method("GET")
     * @Template()
     *
     * @param \App\Entity\Settings\Article $article Article item to edit
     * @return array
     */
    public function editAction(Article $article)
    {
        $return = $this->abstractEditAction($article, 'article', ArticleType::class);

        return $return;
    }

    /**
     * Edits an existing Article entity.
     *
     * @Route("/admin/{slug}/update", name="article_update")
     * @Method("PUT")
     * @Template("settings\article/edit.html.twig")
     *
     * @param \App\Entity\Settings\Article              $article Article item to update
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function updateAction(Article $article, Request $request)
    {
        $return = $this->abstractUpdateAction(
            $article,
            $request,
            'article',
            ArticleType::class
        );

        return $return;
    }

    /**
     * Reassign articles from a provider.
     *
     * @Route("/admin/{slug}/reassign", name="article_reassign")
     * @Method("GET")
     * @Template()
     *
     * @param \App\Entity\Supplier $supplier Supplier articles to reassign
     * @return array
     */
    public function reassignAction(Supplier $supplier)
    {
        $etm = $this->getDoctrine()->getManager();
        $suppliers = $etm->getRepository('App:Settings\Supplier')->getSupplierForReassign($supplier);
        $articles = $etm->getRepository('App:Settings\Article')
            ->getArticleFromSupplier($supplier->getId());

        $reassignForm = $this->createForm(
            ArticleReassignType::class,
            $articles,
            array('action' => $this->generateUrl('article_change', array('slug' => $supplier->getSlug())),)
        );

        return array(
            'reassign_form' => $reassignForm->createView(),
            'suppliers' => $suppliers,
            'articles' => $articles
        );
    }

    /**
     * Creates a new Article entity.
     *
     * @Route("/admin/{slug}/change", name="article_change")
     * @Method("POST")
     * @Template("settings\article/reassign.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request  Form request
     * @param \App\Entity\Supplier                      $supplier Supplier to desactivate
     * @return array
     */
    public function changeAction(Request $request, Supplier $supplier)
    {
        $etm = $this->getDoctrine()->getManager();
        $articles = $etm->getRepository('App:Settings\Article')->getArticleFromSupplier($supplier->getId());

        $reassignForm = $this->createForm(ArticleReassignType::class, $articles, array(
            'action' => $this->generateUrl('article_change', array('slug' => $supplier->getSlug())),
        ));
        $datas = $reassignForm->handleRequest($request);

        foreach ($datas as $data) {
            $input = explode('-', $data->getName());
            list($inputName, $articleId) = $input;
            $inputData = $data->getViewData();
            if ($inputName === 'supplier') {
                $newArticles = $etm->getRepository('App:Settings\Article')->find($articleId);
                $newSupplier = $etm->getRepository('App:Settings\Supplier')->find($inputData);
                // We modify the supplier of the article
                $newArticles->setSupplier($newSupplier);
                // We record the object $article in the database
                $etm->persist($newArticles);
            }
        }
        $etm->flush();
        $message = $this->get('translator')
            ->trans('delete.reassign_ok', array('%supplier.name%' => $supplier->getName()), 'gs_suppliers');
        $this->addFlash('info', $message);
        return $this->redirectToRoute('supplier');
    }

    /**
     * Save order.
     *
     * @Route("/order/{entity}/{field}/{type}", name="article_sort")
     *
     * @param string $entity Entity of the field to sort
     * @param string $field  Field to sort
     * @param string $type   type of sort
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sortAction($entity, $field, $type)
    {
        $this->get('app.helper.controller')->setOrder('article', $entity, $field, $type);

        return $this->redirect($this->generateUrl('article'));
    }
    /**
     * Deletes a Article entity.
     *
     * @Route("/admin/{id}/delete", name="article_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     *
     * @param \App\Entity\Settings\Article              $article Article item to delete
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Article $article, Request $request)
    {
        $form = $this->createDeleteForm($article->getId(), 'article_delete');
        if ($form->handleRequest($request)->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $article->setActive(false);
            $etm->persist($article);
            $etm->flush();
        }

        return $this->redirectToRoute('article');
    }
}
