<?php

/**
 * controller de l'entité Inventory.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version   GIT: a4408b1f9fc87a1f93911d80e8421fef1bd96cab
 *
 * @link      https://github.com/GLSR/glsr
 */
namespace Glsr\GestockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Glsr\GestockBundle\Entity\Inventory;
use Glsr\GestockBundle\Form\InventoryType;

/**
 * class InventoryController.
 *
 * @category   Controller
 */
class InventoryController extends Controller
{
    /**
     * indexAction affiche la page d'accueil du Bundle.
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
     * Afficher l'inventaire sélectionné.
     *
     * @param Inventory $inventory L'inventaire à afficher
     *
     * @return Render
     */
    public function showAction(Inventory $inventory)
    {
        return $this->render(
            'GlsrGestockBundle:Gestock/Inventory:inventory.html.twig',
            array('inventory' => $inventory)
        );
    }

    /**
     * Créer et préparer l'inventaire.
     *
     * Enregistrement de l'inventaire et création du fichier pdf
     *
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function prepareAction()
    {
        $etm = $this->getDoctrine()->getManager();

        $listarticles = $etm->getRepository('GlsrGestockBundle:Article')
            ->findAll();
        $zoneStorages = $etm->getRepository('GlsrGestockBundle:Zonestorage')
            ->findAll();
        $inventory = $etm->getRepository('GlsrGestockBundle:Inventory')
            ->getActive();
        $settings = $etm->getRepository('GlsrGestockBundle:Settings')
            ->find(1);

        $daydate = new \DateTime('now');
        if (!is_dir('pdf')) {
            mkdir('pdf');
        }
        $file = 'pdf/prepare.pdf';
        $datePdf = (string) $daydate->format('d-m-Y');

        //Vérification de l'existance du fichier de même date
        if (!file_exists($file) || empty($inventory)) {
            // Créer et enregistrer le fichier PDF à imprimer
            $this->get('knp_snappy.pdf')
                ->generateFromHtml(
                    $this->renderView(
                        'GlsrGestockBundle:Gestock/Inventory:list.pdf.twig',
                        array(
                            'articles' => $listarticles,
                            'zonestorage' => $zoneStorages,
                            'daydate' => $daydate,
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
                        'footer-right' => 'Page [page]/[toPage]',
                        'footer-line' => true,
                    )
                );
            // Créer l'inventaire avec la date du jour,
            //    et enregistrement Inventory:date
            $newInventory = new Inventory();
            $newInventory->setDate($daydate);
            $newInventory->isActive(1);
            $newInventory->setFile($file);
            // Pour chaque article
            foreach ($listarticles as $article) {
                $newInventory->addArticle($article);
            }
            $etm->persist($newInventory);

            $etm->flush();
            // On définit un message flash
            $this->get('session')
                ->getFlashBag()
                ->add(
                    'info',
                    'glsr.gestock.inventory.prepare.add'
                );

            //    Si Settings:firstInventory == null
            //    Settings:firstInventory = Invetory:date
            if (empty($inventory) && $settings->getFirstInventory(null)) {
                $settings->setFirstInventory($daydate);
                $etm->persist($settings);
                $etm->flush();
            }
        } else {
            // On définit un message flash
            $this->get('session')
                ->getFlashBag()
                ->add(
                    'info',
                    array('glsr.gestock.inventory.prepare.still_exist_pdf')
                );
        }

        // Retour à la page Inventaire:index
        return $this->redirect($this->generateUrl('glstock_inventory'));
    }

    /**
     * Annuler l'inventaire en cours.
     *
     * @param Inventory $inventory
     *
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     *     Retour à index Inventory
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
                $inventory->setFile(null);
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
                'form' => $form->createView(),
                )
        );
    }

    /**
     * Saisie de l'inventaire.
     *
     * @param Inventory $inventory Inventaire sélectionné
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function entryAction(Inventory $inventory, $page)
    {
        // On récupère le nombre d'article par page
        // depuis un paramètre du conteneur
        // cf app/config/parameters.yml
        $nbPerPage = $this->container->getParameter('glsr.nb_per_page');

        $etm = $this->getDoctrine()->getManager();
        $articles = $etm
            ->getRepository('GlsrGestockBundle:Inventory')
            ->getInventoryArticles($nbPerPage, $page);

        // Créer le formulaire de saisie : InventoryType
        $form = $this->createForm(new InventoryType(), $inventory);

        // On récupère la requête
        $request = $this->getRequest();

        // Valider les entrées sur
        //     l'entité Article:realstock
        //     l'entité Inventory:amount
        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            $form->bind($request);
            // On vérifie que les valeurs rentrées sont correctes
            if ($form->isValid()) {
                // On enregistre l'objet $article dans la base de données
                $etm = $this->getDoctrine()->getManager();
                // On enregistre l'objet $inventory dans la base de données
                $etm->persist($inventory);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'glsr.gestock.inventory.seizure.ok');

                return $this->redirect(
                    $this->generateUrl('glstock_inventory')
                );
            } else {
                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'glsr.gestock.inventory.seizure.no');
            }
        }
        // Afficher Formulaire/Inventory:index
        return $this->render(
            'GlsrGestockBundle:Gestock/Inventory:entry.html.twig',
            array(
                'form' => $form->createView(),
                'page'     => $page,
                'nb_page'  => ceil(count($articles) / $nbPerPage) ?: 1,
            )
        );
    }

    /**
     * Valide l'inventaire en cours.
     *
     * @param Inventory $inventory
     *
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     *     Retour à index Inventory
     */
    public function validAction(Inventory $inventory)
    {
        // Enregistrement de l'inventaire en cours
        //     Article:quantity = Article:reelstock
        $form = $this->createFormBuilder()->getForm();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $etm = $this->getDoctrine()->getManager();
                $inventory->isActive(2);
                unlink($inventory->getFile());
                $inventory->setFile(null);
                foreach ($inventory->getArticles() as $article) {
                    $article->setQuantity($article->getRealstock());
                    $article->setRealstock('0.000');
                }
                $etm->persist($inventory);
                $etm->flush();

                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'glsr.gestock.inventory.close.ok');

                return $this->redirect($this->generateUrl('glstock_inventory'));
            } else {
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'glsr.gestock.inventory.close.no');
            }
        }

        return $this->render(
            'GlsrGestockBundle:Gestock/Inventory:valid.html.twig',
            array(
                'inventory' => $inventory,
                'form' => $form->createView(),
                )
        );
    }
}
