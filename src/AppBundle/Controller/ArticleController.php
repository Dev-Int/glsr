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
use AppBundle\Form\Type\ArticleType;

/**
 * Article controller.
 *
 * @category Controller
 *
 * @Route("/articles")
 */
class ArticleController extends AbstractController
{
    /**
     * Lists all Article entities.
     *
     * @Route("/", name="articles")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Article')->createQueryBuilder('a');
        $this->addQueryBuilderSort($qb, 'article');
        $paginator = $this->get('knp_paginator')->paginate($qb, $request->query->get('page', 1), 5);
        
        return array(
            'paginator' => $paginator,
        );
    }

    /**
     * Finds and displays a Article entity.
     *
     * @Route("/{slug}/show", name="articles_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Article $article)
    {
        $deleteForm = $this->createDeleteForm($article->getId(), 'articles_delete');

        return array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Article entity.
     *
     * @Route("/new", name="articles_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $article = new Article();
        $form = $this->createForm(new ArticleType(), $article);

        return array(
            'article' => $article,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Article entity.
     *
     * @Route("/create", name="articles_create")
     * @Method("POST")
     * @Template("AppBundle:Article:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(new ArticleType(), $article);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('articles_show', array('slug' => $article->getSlug()));
        }

        return array(
            'article' => $article,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Article entity.
     *
     * @Route("/{slug}/edit", name="articles_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Article $article)
    {
        $editForm = $this->createForm(new ArticleType(), $article, array(
            'action' => $this->generateUrl('articles_update', array('slug' => $article->getSlug())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($article->getId(), 'articles_delete');

        return array(
            'article' => $article,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Article entity.
     *
     * @Route("/{slug}/update", name="articles_update")
     * @Method("PUT")
     * @Template("AppBundle:Article:edit.html.twig")
     */
    public function updateAction(Article $article, Request $request)
    {
        $editForm = $this->createForm(new ArticleType(), $article, array(
            'action' => $this->generateUrl('articles_update', array('slug' => $article->getSlug())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('articles_edit', array('slug' => $article->getSlug()));
        }
        $deleteForm = $this->createDeleteForm($article->getId(), 'articles_delete');

        return array(
            'article' => $article,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Save order.
     *
     * @Route("/order/{field}/{type}", name="articles_sort")
     */
    public function sortAction($field, $type)
    {
        $this->setOrder('article', $field, $type);

        return $this->redirect($this->generateUrl('articles'));
    }
    /**
     * Deletes a Article entity.
     *
     * @Route("/{id}/delete", name="articles_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Article $article, Request $request)
    {
        $form = $this->createDeleteForm($article->getId(), 'articles_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('articles');
    }
}
