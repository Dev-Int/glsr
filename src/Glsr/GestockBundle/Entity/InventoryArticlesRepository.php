<?php

namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * inventoryArticlesRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InventoryArticlesRepository extends EntityRepository
{
    /**
     * @param objet Inventory $inventory
     *
     * @return Query result
     */
    public function findByInventory($inventory)
    {
        $qb = $this->createQueryBuilder('ia');

        $qb
          ->where('ia.inventory = :inventory')
          ->setParameter('inventory', $inventory);

        return $qb
        ->getQuery()
        ->getResult();
    }
}
