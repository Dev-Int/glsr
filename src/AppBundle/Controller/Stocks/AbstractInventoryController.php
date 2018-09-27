<?php
/**
 * AbstractInventoryController Méthodes communes InventoryController.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller\Stocks;

use AppBundle\Controller\AbstractController;
use AppBundle\Entity\Stocks\Inventory;
use AppBundle\Form\Type\Stocks\InventoryType;
use AppBundle\Form\Type\Stocks\InventoryEditType;
use AppBundle\Form\Type\Stocks\InventoryEditZonesType;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Abstract controller.
 *
 * @category Controller
 */
class AbstractInventoryController extends AbstractController
{
    /**
     * Get the Inventory edit type
     *
     * @param \AppBundle\Controller\Stocks\Inventory $inventory Inventaire à éditer
     * @return array
     */
    protected function getInvetoryEditType(Inventory $inventory)
    {
        $etm = $this->getDoctrine()->getManager();
        $zoneStorages = null;
        $settings = $etm->getRepository('AppBundle:Settings\Settings')->findFirst();

        if ($settings->getInventoryStyle() == 'zonestorage') {
            $zoneStorages = $etm->getRepository('AppBundle:Settings\Diverse\ZoneStorage')->findAll();
            $typeClass = InventoryEditZonesType::class;
        } else {
            $typeClass = InventoryEditType::class;
        }
        $editForm = $this->createForm(
            $typeClass,
            $inventory,
            ['action' => $this->generateUrl('inventory_update', ['id' => $inventory->getId()]),
            'method' => 'PUT',]
        );
        $deleteForm = $this->createDeleteForm($inventory->getId(), 'inventory_delete');

        $return = ['editForm' => $editForm, 'inventory' => $inventory, 'zoneStorages' => $zoneStorages,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),];
        return $return;
    }

    /**
     * Create Create form.
     *
     * @param string $route Route of action form
     * @return \Symfony\Component\Form\Form
     */
    protected function createCreateForm($route)
    {
        $inventory = new Inventory();
        return $this->createForm(
            InventoryType::class,
            $inventory,
            ['attr' => ['id' => 'create'], 'action' => $this->generateUrl($route), 'method' => 'PUT',]
        );
    }

    /**
     * Get LineArticles.
     *
     * @param array $articleLine tableau
     * @param Inventory $inventory Inventaire traité
     * @return array
     */
    protected function getLineArticles(array $articleLine, Inventory $inventory)
    {
        $inventoryArticles = array();
        $lineOk = 0;
        foreach ($inventory->getArticles() as $line) {
            foreach ($articleLine as $key => $art) {
                if (!empty($articleLine) && $line->getArticle()->getName() === $art['article']) {
                    $art['realstock'] = $art['realstock'] + $line->getRealstock();
                    $articleLine[$key]['realstock'] = strval(number_format($art['realstock'], 3));
                    $lineOk = 1;
                }
            }
            if ($lineOk === 0) {
                $inventoryArticles['article'] = $line->getArticle()->getName();
                $inventoryArticles['realstock'] = $line->getRealstock();
                array_push($articleLine, $inventoryArticles);
            }
            $lineOk = 0;
        }
        return $articleLine;
    }

    protected function updateArticles(array $articles, ObjectManager $etm, Inventory $inventory)
    {
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
    }
}
