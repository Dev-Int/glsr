<?php

/**
 * Entity Article.
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
namespace App\Repository\Settings;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository entity.
 *
 * @category Entity
 */
class ArticleRepository extends EntityRepository
{
    /**
     * Displays all articles (query).
     *
     * @return QueryBuilder Requête DQL
     */
    public function getAllItems()
    {
        $query = $this->createQueryBuilder('a')
            ->join('a.supplier', 's')
            ->addSelect('s')
            ->join('a.familyLog', 'fl')
            ->addSelect('fl')
            ->join('a.zoneStorages', 'z')
            ->addSelect('z')
        ;
        
        return $query;
    }

    /**
     * Displays all active articles (query).
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems()
            ->where('s.active = 1')
            ->where('a.active = 1')
        ;
        
        return $query;
    }

    /**
     * Affiche les articles actifs (result).
     *
     * @return array Query result
     */
    public function getResultArticles()
    {
        $query = $this->getItems()->getQuery();
        
        return $query->getResult();
    }

    /**
     * Return the article of the supplier in parameter.
     *
     * @param int $supplier Supplier_id
     *
     * @return array Query result
     */
    public function getArticleFromSupplier($supplier)
    {
        $query = $this->getQueryActiveASC()
            ->andWhere('a.supplier = :id')
            ->setParameter('id', $supplier)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Returns the articles in stock alert.
     *
     * @param integer $count Number of items to display
     * @return array Query result
     */
    public function getStockAlert($count)
    {
        $query = $this->getQueryActiveASC()
            ->andWhere('a.quantity < a.minstock')
            ->setMaxResults($count)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Return query for active and sorted articles.
     */
    private function getQueryActiveASC()
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.active = true')
            ->orderBy('a.name', 'ASC');

        return $query;
    }
}
