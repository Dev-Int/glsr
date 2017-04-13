<?php

/**
 * Entité InventoryArticles.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Repository\Stocks;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Stocks\Inventory;

/**
 * InventoryArticlesRepository
 *
 * @category Entity
 */
class InventoryArticlesRepository extends EntityRepository
{
    /**
     * Obtenir des articles à partir de l'inventaire
     *
     * @param Inventory $inventory
     * @return array
     */
    public function getArticlesFromInventory(Inventory $inventory)
    {
        $query = $this->createQueryBuilder('i')
            ->where('i.inventory = :id')
            ->setParameter('id', $inventory->getId())
            ->getQuery();
        
        return $query->getResult();
    }
}
