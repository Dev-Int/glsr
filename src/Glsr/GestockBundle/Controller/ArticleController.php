<?php

namespace Glsr\GestockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Glsr\GestockBundle\Entity\Article;

use Glsr\GestockBundle\Form\ArticleType;

class ArticleController extends Controller
{
    public function indexAction()
    {
        // On récupère le nombre d'article par page depuis un paramètre du conteneur
        // cf app/config/parameters.yml
        $nbParPage = $this->container->getParameter('glsr.nb_per_page');
        
        $etm = $this->getDoctrine()->getManager();
        $articles = $etm
            ->getRepository('GlsrGestockBundle:Article')
            ->getArticles($nbParPage, $page);

        return $this->render('GlsrGestockBundle:Gestock/Article:index.html.twig', array(
            'articles' => $articles
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
        
    }
}

?>