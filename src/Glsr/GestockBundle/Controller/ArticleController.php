<?php

namespace Glsr\GestockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Glsr\GestockBundle\Entity\Article;

use Glsr\GestockBundle\Form\ArticleType;

class ArticleController extends Controller
{
    public function indexAction($page)
    {
        // On récupère le nombre d'article par page depuis un paramètre du conteneur
        // cf app/config/parameters.yml
        $nbPerPage = $this->container->getParameter('glsr.nb_per_page');
        
        $etm = $this->getDoctrine()->getManager();
        $articles = $etm
            ->getRepository('GlsrGestockBundle:Article')
            ->getArticles($nbPerPage, $page);

        return $this->render('GlsrGestockBundle:Gestock/Article:index.html.twig', array(
            'articles' => $articles,
            'page'       => $page,
            'nb_page' => ceil(count($articles) / $nbPerPage) ?: 1
        ));
    }
    
    public function addAction()
    {
        $article = new Article();
        
        // On crée le formulaire grâce à l'ArticleType
        $form = $this->createForm(new ArticleType(), $article);
        
        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            $form->bind($request);

            // On vérifie que les valeurs rentrées sont correctes
            if ($form->isValid()) {

                // On enregistre l'objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Article bien ajouté');

                // On redirige vers la page de visualisation de l'article nouvellement créé
                return $this->redirect($this->generateUrl('glstock_art_show', array('name' => $article->getName())));
            }
        }

        // À ce stade :
        // - soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        return $this->render('GlsrGestockBundle:Gestock/Article:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    public function editAction(Article $article)
    {
        // On crée le formulaire grâce à l'ArticleType
        $form = $this->createForm(new ArticleType(), $article);
        
        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            $form->bind($request);

            // On vérifie que les valeurs rentrées sont correctes
            if ($form->isValid()) {

                // On enregistre l'objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Article bien modifié');

                // On redirige vers la page de visualisation de l'article nouvellement créé
                return $this->redirect($this->generateUrl('glstock_art_show', array('name' => $article->getName())));
            }
        }

        // À ce stade :
        // - soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        return $this->render('GlsrGestockBundle:Gestock/Article:edit.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    public function deleteAction(Article $article)
    {
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'article contre cette faille
        $form = $this->createFormBuilder()->getForm();
        
        //On modifie l'état actif de l'article
        $article->setActive(0);
        
        $request = $this->getRequest();        
        if ($request->getMethod() == 'POST') {
            // Si la requête est en POST, on supprimera l'article
            $form->bind($request);
            
            if ($form->isValid()) {
                // On supprime l'article
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($article);
                $etm->flush();
                
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'article.delete.ok');

                // Puis on redirige vers l'accueil
                return $this->redirect($this->generateUrl('glstock_home'));
            } else {
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'Article pas désactivé');
            }
        }

        // Si la requête est en GET, 
        // on affiche une page de confirmation avant de supprimer
        return $this->render(
            'GlsrGestockBundle:Gestock/Article:delete.html.twig',
            array(
                'article' => $article,
                'form'    => $form->createView()
                )
        );
    }
    
    public function showAction(Article $article)
    {
        return $this->render('GlsrGestockBundle:Gestock/Article:index.html.twig', array(
            'article' => $article
        ));
    }
}

?>