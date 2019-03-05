<?php

/**
 * Entity Orders.
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
namespace App\Repository\Orders;

use Doctrine\ORM\EntityRepository;

/**
 * OrdersRepository
 *
 * @category Entity
 */
class OrdersRepository extends EntityRepository
{
    /**
     * Return the last orders.
     *
     * @param integer $count Nombre d'élément à afficher
     * @return array Query result
     */
    public function getLastOrder($count)
    {
        $query = $this->getAllItems()
            ->setMaxResults($count)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Returns the last deliveries.
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
     * Return the last bills.
     *
     * @param integer $count Nombre d'élément à afficher
     * @return array Query result
     */
    public function getLastInvoice($count)
    {
        $query = $this->getItems()
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
    public function getAllItems()
    {
        $query = $this->getItems()
            ->where('o.delivdate > :date')
            ->setParameter('date', date('Y-m-d'));

        return $query;
    }

    /**
     * Find active Orders.
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getItems()
    {
        $query = $this->createQueryBuilder('o')
            ->orderBy('o.id', 'DESC')
            ->where('o.status = 1');

        return $query;
    }

    /**
     * Find Orders for delivering.
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findDeliveries()
    {
        $query = $this->getItems()
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
        $query = $this->getItems()
            ->where('o.delivdate < :date')
            ->setParameter('date', date('Y-m-d'))
            ->andWhere('o.status > 1');

        return $query;
    }
}
