<?php

/**
 * Entity InventoryArticles.
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
use App\Entity\Stocks\Inventory;

/**
 * InventoryArticlesRepository entity.
 *
 * @category Entity
 */
class InventoryArticlesRepository extends EntityRepository
{
    /**
     * Returns inventory articles.
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
