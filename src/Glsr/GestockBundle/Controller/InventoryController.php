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
    var_dump($settings);
        $daydate = new \DateTime('now');
        $file = 'bundles/glsrgestock/pdf/prepare-' . $daydate->format('Ymd') . '.pdf';

        //Vérification de l'existance du fichier de même date
        if (!file_exists($file) && empty($inventory)){
            // Créer et enregistrer le fichier PDF à imprimer
            $this->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    'GlsrGestockBundle:Gestock/Inventory:list.pdf.twig',
                    array(
                        'articles'    => $articles,
                        'zonestorage' => $zoneStorages,
                        'daydate'     => $daydate
                    )
                ), 
                $file
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
                ->add('info', 'Inventaire bien ajouté');
        } else {
            // On définit un message flash
            $this->get('session')
                ->getFlashBag()
                ->add('info', 'Le fichier prepare-' 
                        . $daydate->format('Ymd') . 
                        '.pdf est déjà créé !');
        }
        
        //    Si Settings:firstInventory == null 
        //    Settings:firstInventory = Invetory:date 
        if (empty($inventory) and $settings->getFirstInventory(null)) {
            $settings->setFirstInventory($daydate);
            $etm->persist($settings);
            $etm->flush();
        }
        // retour à la page Inventaire:index
        return $this->redirect($this->generateUrl('glstock_inventory'));
    }
    
    /**
     * Annuler l'inventaire en cours
     * 
     * @return RedirectResponse Retour page index
     */
    public function cancelAction()
    {
        // Récupérer l'entité Inventaire

        // Si inventaire en cours, prévenir que les saisies seront perdues
        
        // Désactiver l'inventaire en cours
        
        // retour à la page Inventaire:index

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
