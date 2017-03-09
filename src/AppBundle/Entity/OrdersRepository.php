<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * OrdersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrdersRepository extends EntityRepository
{
    /**
     * Renvoi les dernières commandes.
     *
     * @param integer $count Nombre d'élément à afficher
     * @return array Query result
     */
    public function getLastOrder($count)
    {
        $query = $this->findOrders()
            ->setMaxResults($count)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Renvoi les dernières commandes.
     *
     * @param integer $count Nombre d'élément à afficher
     * @return array Query result
     */
    public function getLastDelivery($count)
    {
        $query = $this->findDeliveries()
            ->setMaxResults($count)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Find Orders before delivering.
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findOrders()
    {
        $query = $this->findActive()
            ->andWhere('o.delivdate > :date')
            ->setParameter('date', date('Y-m-d'));

        return $query;
    }

    /**
     * Find Orders for delivering.
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findDeliveries()
    {
        $query = $this->findActive()
            ->andWhere('o.delivdate <= :date')
            ->setParameter('date', date('Y-m-d'));

        return $query;
    }

    private function findActive()
    {
        $query = $this->createQueryBuilder('o')
            ->orderBy('o.id', 'DESC')
            ->where('o.status = 1');

        return $query;
    }
}
