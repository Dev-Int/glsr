<?php

namespace Glsr\GestockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Glsr\GestockBundle\Entity\Supplier;

use Glsr\GestockBundle\Form\SupplierType;

class SupplierController extends Controller
{
    public function indexAction($page)
    {
        // On récupère le nombre d'article par page depuis un paramètre du conteneur
        // cf app/config/parameters.yml
        $nbPerPage = $this->container->getParameter('glsr.nb_per_page');
        
        $etm = $this->getDoctrine()->getManager();
        $suppliers = $etm
            ->getRepository('GlsrGestockBundle:Supplier')
            ->getSuppliers($nbPerPage, $page);

        return $this->render('GlsrGestockBundle:Gestock/Supplier:index.html.twig', array(
            'suppliers' => $suppliers,
            'page'       => $page,
            'nb_page' => ceil(count($suppliers) / $nbPerPage) ?: 1
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
    
    public function deleteAction(Supplier $supplier)
    {
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression du fournisseur contre cette faille
        $form = $this->createFormBuilder()->getForm();
        
        //On modifie l'état actif du fournisseur
        $supplier->setActive(0);
        
        $request = $this->getRequest();        
        if ($request->getMethod() == 'POST') {
            // Si la requête est en POST, on supprimera le fournisseur
            $form->bind($request);
            
            if ($form->isValid()) {
                // On supprime le fournisseur
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($supplier);
                $etm->flush();
                
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'supplier.delete.ok');

                // Puis on redirige vers l'accueil
                return $this->redirect($this->generateUrl('glstock_home'));
            } else {
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'Supplier pas désactivé');
            }
        }

        // Si la requête est en GET, 
        // on affiche une page de confirmation avant de supprimer
        return $this->render(
            'GlsrGestockBundle:Gestock/Supplier:delete.html.twig',
            array(
                'supplier' => $supplier,
                'form'    => $form->createView()
                )
        );
    }
    
    public function showAction(Supplier $supplier)
    {
        return $this->render('GlsrGestockBundle:Gestock/Supplier:index.html.twig', array(
            'supplier' => $supplier
        ));
    }
}
