<?php

namespace Glsr\GestockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Glsr\GestockBundle\Entity\Supplier;

use Glsr\GestockBundle\Form\SupplierType;

class SupplierController extends Controller
{
    public function indexAction()
    {
        // On récupère le nombre d'article par page depuis un paramètre du conteneur
        // cf app/config/parameters.yml
        $nbParPage = $this->container->getParameter('glsr.nb_per_page');
        
        $etm = $this->getDoctrine()->getManager();
        $suppliers = $etm
            ->getRepository('GlsrGestockBundle:Supplier')
            ->getSuppliers($nbParPage, $page);

        return $this->render('GlsrGestockBundle:Gestock/Supplier:index.html.twig', array(
            'suppliers' => $suppliers
        ));
    }
    
    public function addAction()
    {
        $supplier = new Supplier();
        
        // On crée le formulaire grâce à l'ArticleType
        $form = $this->createForm(new SupplierType(), $supplier);
        
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
                $em->persist($supplier);
                $em->flush();

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Fournisseur bien ajouté');

                // On redirige vers la page de visualisation de l'article nouvellement créé
                return $this->redirect($this->generateUrl('glstock_suppli_show', array('name' => $supplier->getName())));
            }
        }

        // À ce stade :
        // - soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        return $this->render('GlsrGestockBundle:Gestock/Supplier:add.html.twig', array(
          'form' => $form->createView()
        ));
    }
    
    public function editAction(Supplier $supplier)
    {
        // On crée le formulaire grâce à l'ArticleType
        $form = $this->createForm(new SupplierType(), $supplier);
        
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
                $em->persist($supplier);
                $em->flush();

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Fournisseur bien modifié');

                // On redirige vers la page de visualisation de l'article nouvellement créé
                return $this->redirect($this->generateUrl('glstock_suppli_show', array('name' => $supplier->getName())));
            }
        }
        return $this->render('GlsrGestockBundle:Gestock/Supplier:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
