<?php
/**
 * InventoryController controller des inventaires.
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
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use AppBundle\Controller\AbstractInventoryController;
use AppBundle\Entity\Inventory;
use AppBundle\Entity\InventoryArticles;
use AppBundle\Form\Type\InventoryValidType;

/**
 * Inventory controller.
 *
 * @category Controller
 *
 * @Route("/inventory")
 */
class InventoryController extends AbstractInventoryController
{
    /**
     * Lists all Inventory entities.
     *
     * @Route("/", name="inventory")
     * @Method("GET")
     * @Template()
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Paginate request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $item = $this->container->getParameter('knp_paginator.page_range');
        $etm = $this->getDoctrine()->getManager();
        $qbd = $etm->getRepository('AppBundle:Inventory')->getInventory();
        
        $createForm = $this->createCreateForm('inventory_create');

        $paginator = $this->get('knp_paginator')->paginate($qbd, $request->query->get('page', 1), $item);

        return array(
            'paginator' => $paginator,
            'create_form' => $createForm->createView(),
        );
    }

    /**
     * Finds and displays a Inventory entity.
     *
     * @Route("/{id}/show", name="inventory_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Inventory $inventory Inventory item to display
     * @return array
     */
    public function showAction(Inventory $inventory)
    {
        $etm = $this->getDoctrine()->getManager();
        $zoneStorages = null;
        $settings = $etm->getRepository('AppBundle:Settings')->find(1);
        if ($settings->getInventoryStyle() == 'zonestorage') {
            $zoneStorages = $etm->getRepository('AppBundle:ZoneStorage')->findAll();
        }
        $inventoryArticles = $etm
            ->getRepository('AppBundle:InventoryArticles')
            ->getArticlesFromInventory($inventory);

        $deleteForm = $this->createDeleteForm($inventory->getId(), 'inventory_delete');
        
        return array(
            'inventory'         => $inventory,
            'zoneStorages'      => $zoneStorages,
            'inventoryArticles' => $inventoryArticles,
            'delete_form'       => $deleteForm->createView(),
        );
    }

    /**
     * Creates a new Inventory entity.
     *
     * @Route("/admin/create", name="inventory_create")
     * @Method("PUT")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $etm = $this->getDoctrine()->getManager();
        $articles = $etm->getRepository('AppBundle:Article')->getResultArticles();
        $settings = $etm->getRepository('AppBundle:Settings')->find(1);

        $inventory = new Inventory();
        $form = $this->createCreateForm('inventory_create');
        if ($form->handleRequest($request)->isValid()) {
            $etm->persist($inventory);

            // Saving the first inventory
            if (empty($settings->getFirstInventory)) {
                $settings->setFirstInventory($inventory->getDate());
                $etm->persist($settings);
            }
            // Saving of articles in the inventory
            foreach ($articles as $article) {
                foreach ($article->getZoneStorages()->getSnapshot() as $zoneStorage) {
                    $inventoryArticles = new InventoryArticles();
                    $inventoryArticles->setArticle($article);
                    $inventoryArticles->setInventory($inventory);
                    $inventoryArticles->setQuantity($article->getQuantity());
                    $inventoryArticles->setRealstock(0);
                    $inventoryArticles->setUnitStorage($article->getUnitStorage());
                    $inventoryArticles->setPrice($article->getPrice());
                    $inventoryArticles->setZoneStorage($zoneStorage->getName());
                    $etm->persist($inventoryArticles);
                }
            }
            $etm->flush();

            return $this->redirectToRoute(
                'inventory_print_prepare',
                array('id' => $inventory->getId(), 'inventoryStyle' => $settings->getInventoryStyle())
            );
        }
    }

    /**
     * Displays a form to edit an existing Inventory entity.
     *
     * @Route("/admin/{id}/edit", name="inventory_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Inventory $inventory Inventory item to edit
     * @return array
     */
    public function editAction(Inventory $inventory)
    {
        $return = $this->getInvetoryEditType($inventory);
        
        return $return;
    }

    /**
     * Edits an existing Inventory entity.
     *
     * @Route("/admin/{id}/update", name="inventory_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Inventory:edit.html.twig")
     *
     * @param \AppBundle\Entity\Inventory               $inventory Inventory item to update
     * @param \Symfony\Component\HttpFoundation\Request $request   Form request
     * @return array
     */
    public function updateAction(Inventory $inventory, Request $request)
    {
        $return = $this->getInvetoryEditType($inventory);
        
        if ($return['editForm']->handleRequest($request)->isValid()) {
            $inventory->setStatus('2');
            $this->getDoctrine()->getManager()->flush();

            $return = $this->redirectToRoute(
                'inventory_edit',
                array('id' => $inventory->getId(), 'zoneStorages' => $return['zoneStorages'],)
            );
        }
        return $return;
    }

    /**
     * Displays a form to valid an existing Inventory entity.
     *
     * @Route("/admin/{id}/valid", name="inventory_valid", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Inventory $inventory Inventory item to validate
     * @return array
     */
    public function validAction(Inventory $inventory)
    {
        $validForm = $this->createForm(InventoryValidType::class, $inventory, array(
            'action' => $this->generateUrl('inventory_close', array('id' => $inventory->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($inventory->getId(), 'inventory_delete');

        return array(
            'inventory' => $inventory,
            'valid_form'   => $validForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Close an existing Inventory entity.
     *
     * @Route("/admin/{id}/close", name="inventory_close", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("AppBundle:Inventory:valid.html.twig")
     *
     * @param \AppBundle\Entity\Inventory               $inventory Inventory item to close
     * @param \Symfony\Component\HttpFoundation\Request $request   Form request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function closeAction(Inventory $inventory, Request $request)
    {
        $etm = $this->getDoctrine()->getManager();
        $articles = $etm->getRepository('AppBundle:Article')->getResultArticles();

        $validForm = $this->createForm(InventoryValidType::class, $inventory, array(
            'action' => $this->generateUrl('inventory_close', array('id' => $inventory->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($inventory->getId(), 'inventory_delete');

        $return = array(
            'inventory' => $inventory,
            'valid_form'   => $validForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );

        if ($validForm->handleRequest($request)->isValid()) {
            $inventory->setStatus(3);
            $etm->persist($inventory);
            $articleLine = array();
            $articleLine = $this->getLineArticles($articleLine, $inventory);
            foreach ($articles as $article) {
                foreach ($articleLine as $line) {
                    if ($article->getName() === $line['article']) {
                        $article->setQuantity($line['realstock']);
                        $etm->persist($article);
                    }
                }
            }
            $etm->flush();

            $return = $this->redirectToRoute('inventory');
        }

        return $return;
    }

    /**
     * Deletes a Inventory entity.
     *
     * @Route("/admin/{id}/delete", name="inventory_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     *
     * @param \AppBundle\Entity\Inventory               $inventory Inventory item to delete
     * @param \Symfony\Component\HttpFoundation\Request $request   Form request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Inventory $inventory, Request $request)
    {
        $return = $this->abstractDeleteWithArticlesAction($inventory, $request, 'inventory');
        
        return $return;
    }

    /**
     * Print the current inventory.<br />Creating a `PDF` file for viewing on paper
     *
     * @Route("/{id}/print/", name="inventory_print", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Inventory $inventory Inventory item to print
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function printAction(Inventory $inventory)
    {
        $file = $inventory->getDate()->format('Ymd') . '-inventory.pdf';
        // Create and save the PDF file to print
        $html = $this->renderView(
            'AppBundle:Inventory:print.pdf.twig',
            array('articles' => $inventory->getArticles(), 'inventory' => $inventory,)
        );
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                $this->get('app.helper.controller')
                    ->getArray((string) $inventory->getDate()->format('d/m/Y'), '- Inventaire -')
            ),
            200,
            ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'attachment; filename="' . $file . '"',]
        );
    }

    /**
     * Print the preparation of inventory.<br />Creating a `PDF` file for viewing on paper
     *
     * @Route("/{id}/print/{inventoryStyle}/prepare", name="inventory_print_prepare", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     *
     * @param \AppBundle\Entity\Inventory $inventory      Inventory to print
     * @param string                      $inventoryStyle Style of inventory
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prepareDataAction(Inventory $inventory, $inventoryStyle)
    {
        $html = $this->getHtml($inventory, $inventoryStyle);

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                $this->get('app.helper.controller')
                    ->getArray((string) $inventory->getDate()->format('d/m/Y'), '- Inventaire -')
            ),
            200,
            ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'attachment; filename="prepare.pdf"',]
        );
    }

    /**
     * get Html for PDF file.
     *
     * @param \AppBundle\Entity\Inventory $inventory      Inventory entity
     * @param string                      $inventoryStyle Style of inventory
     * @return string The rendered view
     */
    private function getHtml(Inventory $inventory, $inventoryStyle)
    {
        $html = '';
        $etm = $this->getDoctrine()->getManager();
        $articles = $etm->getRepository('AppBundle:Article')->getArticles()->getQuery()->getResult();
        $zoneStorages = $etm->getRepository('AppBundle:Zonestorage')->findAll();
        
        if ($inventoryStyle == 'global') {
            $html = $this->renderView(
                'AppBundle:Inventory:list-global.pdf.twig',
                array('articles' => $articles, 'daydate' => $inventory->getDate(),)
            );
        } else {
            $html = $this->renderView(
                'AppBundle:Inventory:list-ordered.pdf.twig',
                array('articles' => $articles, 'zonestorage' => $zoneStorages, 'daydate' => $inventory->getDate(),)
            );
        }
        return $html;
    }
}
