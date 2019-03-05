<?php

/**
 * Entity Inventory.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace App\Repository\Stocks;

use Doctrine\ORM\EntityRepository;

/**
 * InventoryRepository entity.
 *
 * @category Entity
 */
class InventoryRepository extends EntityRepository
{
    /**
     * Displays all inventories.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getAllItems()
    {
        $query = $this->createQueryBuilder('i')
            ->orderBy('i.id', 'DESC');
        
        return $query;
    }

    /**
     * Displays inventories in progress.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems()
            ->where('i.status > 0');

        return $query;
    }

    /**
     * Return the latest inventories.
     *
     * @param integer $count Number of items to display
     * @return array Query result
     */
    public function getLastInventory($count)
    {
        $query = $this->getItems()
            ->setMaxResults($count)
            ->getQuery();

        return $query->getResult();
    }
}
