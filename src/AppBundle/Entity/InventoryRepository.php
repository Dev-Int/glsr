<?php

/**
 * Entité Inventory.
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
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * InventoryRepository
 *
 * @category Entity
 */
class InventoryRepository extends EntityRepository
{
    /**
     * Affiche les inventaires actifs.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getInventory()
    {
        $query = $this->findActive();
        
        return $query;
    }

    /**
     * Renvoi les derniers inventaires.
     *
     * @param integer $count Nombre d'élément à afficher
     * @return array Query result
     */
    public function getLastInventory($count)
    {
        $query = $this->findActive()
            ->setMaxResults($count)
            ->getQuery();

        return $query->getResult();
    }

    private function findActive()
    {
        $query = $this->createQueryBuilder('i')
            ->where('i.status > 0')
            ->orderBy('i.id', 'DESC');

        return $query;
    }
}
