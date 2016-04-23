<?php

/**
 * Entité Article.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    since 1.0.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ArticleRepository.
 *
 * @category   Entity
 */
class ArticleRepository extends EntityRepository
{
    /**
     * Affiche les articles actifs.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getArticles()
    {
        $query = $this->createQueryBuilder('a')
            ->leftjoin('a.supplier', 's')
            ->addSelect('s')
            ->where('a.active = 1')
            ->orderBy('a.name', 'ASC');
        
        return $query;
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
        $query = $this->createQueryBuilder('a')
            ->where('a.active = 1')
            ->where('a.supplier = :id')
            ->setParameter('id', $supplier)
            ->orderBy('a.name', 'ASC')
            ->getQuery();

        return $query->getResult();
    }
}
