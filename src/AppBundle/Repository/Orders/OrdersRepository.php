<?php

/**
 * Entité Orders.
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
namespace AppBundle\Repository\Orders;

use Doctrine\ORM\EntityRepository;

/**
 * OrdersRepository
 *
 * @category Entity
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
     * Renvoi les dernières commandes.
     *
     * @param integer $count Nombre d'élément à afficher
     * @return array Query result
     */
    public function getLastInvoice($count)
    {
        $query = $this->findItem()
            ->setMaxResults($count)
            ->where('o.status = 2')
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
        $query = $this->findItem()
            ->where('o.delivdate > :date')
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
        $query = $this->findItem()
            ->where('o.delivdate <= :date')
            ->setParameter('date', date('Y-m-d'))
            ->andWhere('o.status = 1');

        return $query;
    }

    /**
     * Find Orders for billing.
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findInvoices()
    {
        $query = $this->findItem()
            ->where('o.delivdate < :date')
            ->setParameter('date', date('Y-m-d'))
            ->andWhere('o.status > 1');

        return $query;
    }

    private function findItem()
    {
        $query = $this->createQueryBuilder('o')
            ->orderBy('o.id', 'DESC')
            ->where('o.status = 1');

        return $query;
    }
}
