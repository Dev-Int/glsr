<?php

/**
 * Entité Article.
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
namespace AppBundle\Repository\Settings;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository.
 *
 * @category Entity
 */
class ArticleRepository extends EntityRepository
{
    /**
     * Affiche les articles actifs.
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
     * Affiche les articles actifs.
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
     * Affiche les articles actifs.
     *
     * @return array Query result
     */
    public function getResultArticles()
    {
        $query = $this->getItems()->getQuery();
        
        return $query->getResult();
    }

    /**
     * Renvoi les article du fournisseur en paramètre.
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
     * Renvoi les articles en stock d'alerte.
     *
     * @param integer $count Nombre d'élément à afficher
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

    private function getQueryActiveASC()
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.active = true')
            ->orderBy('a.name', 'ASC');

        return $query;
    }
}
