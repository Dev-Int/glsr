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
 * @version since 1.0.0
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller;

use AppBundle\Controller\AbstractController;
use AppBundle\Entity\Inventory;
use AppBundle\Form\Type\InventoryType;
use AppBundle\Form\Type\InventoryEditType;
use AppBundle\Form\Type\InventoryEditZonesType;

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
     * @param \AppBundle\Controller\Inventory $inventory Inventaire à éditer
     * @return array
     */
    public function getInvetoryEditType(Inventory $inventory)
    {
        $etm = $this->getDoctrine()->getManager();
        $zoneStorages = null;
        $settings = $etm->getRepository('AppBundle:Settings')->find(1);
        if ($settings->getInventoryStyle() == 'zonestorage') {
            $zoneStorages = $etm->getRepository('AppBundle:ZoneStorage')->findAll();
            $typeClass = InventoryEditZonesType::class;
        } else {
            $typeClass = InventoryEditType::class;
        }
        $editForm = $this->createForm($typeClass, $inventory, [
            'action' => $this->generateUrl('inventory_update', ['id' => $inventory->getId()]),
            'method' => 'PUT',]
        );
        $deleteForm = $this->createDeleteForm($inventory->getId(), 'inventory_delete');

        $return = ['editForm' => $editForm,
            'inventory' => $inventory,
            'zoneStorages' => $zoneStorages,
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
    public function createCreateForm($route)
    {
        $inventory = new Inventory();
        return $this->createForm(
            InventoryType::class,
            $inventory,
            ['attr' => ['id' => 'create'], 'action' => $this->generateUrl($route), 'method' => 'PUT',]
        );
    }
    
    /**
     * Get Line Articles
     *
     * @param array $articleLine
     * @param Inventory $inventory
     * @return array $articleLine
     */
    public function getLineArticles(array $articleLine, Inventory $inventory)
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
}
