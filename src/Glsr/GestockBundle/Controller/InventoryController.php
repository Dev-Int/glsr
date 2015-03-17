<?php
/**
 * controller de l'entité Inventory
 * 
 * PHP Version 5
 * 
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version   GIT: a4408b1f9fc87a1f93911d80e8421fef1bd96cab
 * @link      https://github.com/GLSR/glsr
 */

namespace Glsr\GestockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Glsr\GestockBundle\Entity\Inventory;

/**
 * class InventoryController
 * 
 * @category   Controller
 * @package    Gestock
 * @subpackage Inventory
 */
class InventoryController extends Controller
{
    /**
     * indexAction affiche la page d'accueil du Bundle
     * 
     * @return Render
     */
    public function indexAction()
    {
        $etm = $this->getDoctrine()->getManager();
        $inventory = $etm->getRepository('GlsrGestockBundle:Inventory')
            ->getActive();

        return $this->render(
            'GlsrGestockBundle:Gestock/Inventory:index.html.twig',
            array('inventory' => $inventory)
        );
    }
    
    /**
     * Afficher l'inventaire sélectionné
     * 
     * @param Inventory $inventory L'inventaire à afficher
     * 
     * @return Render
     */
    public function showAction(Inventory $inventory) {
        return $this->render(
            'GlsrGestockBundle:Gestock/Inventory:inventory.html.twig',
            array(
                'inventory' => $inventory,
            )
        );
    }
    
    /**
     * Préparer l'inventaire
     * 
     * Enregistrement de l'inventaire et création du fichier pdf
     * 
     * @return RedirectResponse
     */
    public function prepareAction()
    {
        $etm = $this->getDoctrine()->getManager();
        
        $articles = $etm->getRepository('GlsrGestockBundle:Article')
            ->findAll();
        $zoneStorages = $etm->getRepository('GlsrGestockBundle:Zonestorage')
            ->findAll();
        $inventory = $etm->getRepository('GlsrGestockBundle:Inventory')
            ->getActive();
        $settings = $etm->getRepository('GlsrGestockBundle:Settings')
            ->find(1);

        $daydate = new \DateTime('now');
        if (!is_dir('pdf')){
            mkdir('pdf');
        }
        $file = 'pdf/prepare-' . $daydate->format('Ymd') . '.pdf';
        $datePdf = (string)$daydate->format('d-m-Y');

        //Vérification de l'existance du fichier de même date
        if (!file_exists($file) || empty($inventory)){
            // Créer et enregistrer le fichier PDF à imprimer
            $this->get('knp_snappy.pdf')
                ->generateFromHtml(
                    $this->renderView(
                        'GlsrGestockBundle:Gestock/Inventory:list.pdf.twig',
                        array(
                            'articles'    => $articles,
                            'zonestorage' => $zoneStorages,
                            'daydate'     => $daydate
                        )
                    ), 
                    $file,
                    array(
                        'margin-top' => 15,
                        'header-spacing' => 5,
                        'header-font-size' => 8,
                        'header-left' => 'Gestock',
                        'header-center' => '- Inventaire -',
                        'header-right' => $datePdf,
                        'header-line' => true,
                        'margin-bottom' => 15,
                        'footer-spacing' => 5,
                        'footer-font-size' => 8,
                        'footer-left' => 'GLSR &copy 2014 and beyond.',
                        'footer-right' => "Page [page]/[toPage]",
                        'footer-line' => true
                    )
                );
            // Créer l'inventaire avec la date du jour,
            //    et enregistrement Inventory:date
            $newInventory = new Inventory();
            $newInventory->setDate($daydate);
            $newInventory->isActive(1);
            $newInventory->setFile($file);

            $etm->persist($newInventory);
            $etm->flush();
            // On définit un message flash
            $this->get('session')
                ->getFlashBag()
                ->add('info', 'glsr.gestock.inventory.prepare.add');

            //    Si Settings:firstInventory == null 
            //    Settings:firstInventory = Invetory:date 
            if (empty($inventory) and $settings->getFirstInventory(null)) {
                $settings->setFirstInventory($daydate);
                $etm->persist($settings);
                $etm->flush();
            }
        } else {
            // On définit un message flash
            $this->get('session')
                ->getFlashBag()
                ->add('info', 
                    array(
                        'glsr.gestock.inventory.prepare.still_exit_pdf', 
                        $daydate->format('Ymd')
                    )
                );
        }
        
        // retour à la page Inventaire:index
        return $this->redirect($this->generateUrl('glstock_inventory'));
    }
    
    /**
     * Annuler l'inventaire en cours
     * 
     * @param Inventory $inventory
     * @return RedirectResponse Retour index Inventory
     */
    public function cancelAction(Inventory $inventory)
    {
        $form = $this->createFormBuilder()->getForm();
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            if ($form->isValid()) {
                $etm = $this->getDoctrine()->getManager();
                $inventory->isActive(0);
                unlink($inventory->getFile());
                $inventory->setFile(NULL);
                $etm->persist($inventory);
                $etm->flush();
                
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'glsr.gestock.inventory.cancel.ok');

                return $this->redirect($this->generateUrl('glstock_inventory'));
            } else {
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'glsr.gestock.inventory.cancel.no');
            }
        }

        return $this->render(
            'GlsrGestockBundle:Gestock/Inventory:cancel.html.twig',
            array(
                'inventory' => $inventory,
                'form'    => $form->createView()
                )
        );
        
    }
    
    /**
     * Saisie de l'inventaire
     */
    public function entryAction()
    {
        // Récupérer l'entité Inventaire
        
        // Créer le formulaire de saisie : InventoryType
        
        // Valider les entrées sur 
        //     l'entité Article:reelstock
        //     l'entité Inventory:amount
        
        // Afficher Formulaire/Inventory:index
    }
    
    /**
     * Gestion des écarts de stock
     */
    public function differencesStockAction()
    {
        // Article:quantity - Article:reelstock
    }
    
    /**
     * Valide l'inventaire en cours
     */
    public function validAction()
    {
        // Enregistrement de l'inventaire en cours
        //     Article:quantity = Article:reelstock
    }
}
