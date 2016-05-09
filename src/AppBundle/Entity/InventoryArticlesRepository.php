<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Inventory;

/**
 * InventoryArticlesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InventoryArticlesRepository extends EntityRepository
{
    public function getArticlesFromInventory(Inventory $inventory) {
        $query = $this->createQueryBuilder('i')
            ->where('i.inventory = :id')
            ->setParameter('id', $inventory->getId())
            ->getQuery();
        
        return $query->getResult();
    }
}
