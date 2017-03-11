<?php
/**
 * ArticleController controller des articles.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version since 1.0.0
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Article;
use AppBundle\Entity\Supplier;
use AppBundle\Form\Type\ArticleType;
use AppBundle\Form\Type\ArticleReassignType;

/**
 * Article controller.
 *
 * @category Controller
 *
 * @Route("/article")
 */
class ArticleController extends AbstractController
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
        $return = $this->abstractIndexAction('Article', $request);
        
        return $return;
    }

    /**
     * Finds and displays a Article entity.
     *
     * @Route("/{slug}/show", name="article_show")
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Article $article Article item to display
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
            'Article',
            'AppBundle\Entity\Article',
            ArticleType::class
        );

        return $return;
    }

    /**
     * Creates a new Article entity.
     *
     * @Route("/admin/create", name="article_create")
     * @Method("POST")
     * @Template("AppBundle:Article:new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Form request
     * @return array
     */
    public function createAction(Request $request)
    {
        $return = $this->abstractCreateAction(
            $request,
            'Article',
            'AppBundle\Entity\Article',
            ArticleType::class
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
     * @param \AppBundle\Entity\Article $article Article item to edit
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
     * @Template("AppBundle:Article:edit.html.twig")
     *
     * @param \AppBundle\Entity\Article                 $article Article item to update
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
     * Réassigner les articles d'un fournisseur.
     *
     * @param Supplier $supplier Fournisseur à réassigner
     * @Route("/admin/{slug}/reassign", name="article_reassign")
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Supplier $supplier Supplier articles to reassign
     * @return array
     */
    public function reassignAction(Supplier $supplier)
    {
        $etm = $this->getDoctrine()->getManager();
        $suppliers = $etm->getRepository('AppBundle:Supplier')->getSupplierForReassign($supplier);
        $articles = $etm->getRepository('AppBundle:Article')
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
     * @Template("AppBundle:Article:reassign.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request  Form request
     * @param \AppBundle\Entity\Supplier                $supplier Supplier to desactivate
     * @return array
     */
    public function changeAction(Request $request, Supplier $supplier)
    {
        $etm = $this->getDoctrine()->getManager();
        $articles = $etm->getRepository('AppBundle:Article')->getArticleFromSupplier($supplier->getId());

        $reassignForm = $this->createForm(ArticleReassignType::class, $articles, array(
            'action' => $this->generateUrl('article_change', array('slug' => $supplier->getSlug())),
        ));
        $datas = $reassignForm->handleRequest($request);

        foreach ($datas as $data) {
            $input = explode('-', $data->getName());
            list($inputName, $articleId) = $input;
            $inputData = $data->getViewData();
            if ($inputName === 'supplier') {
                $newArticles = $etm->getRepository('AppBundle:Article')->find($articleId);
                $newSupplier = $etm->getRepository('AppBundle:Supplier')->find($inputData);
                //On modifie le fournisseur de l'article
                $newArticles->setSupplier($newSupplier);
                // On enregistre l'objet $article dans la base de donnÃ©es
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
     * @param \AppBundle\Entity\Article                 $article Article item to delete
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
