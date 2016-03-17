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
 * @version    0.1.0
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
     * Affiche les articles actifs, avec une pagination.
     *
     * @param int $nbPerPage Nombre d'article par page
     * @param int $page      Numéro de la page en cours
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator Objet Paginator
     *
     * @throws \InvalidArgumentException
     */
    public function getArticles($nbPerPage, $page)
    {
        if ($page < 1) {
            throw new \InvalidArgumentException(
                'l\'argument $page ne peut être inférieur à 1 (valeur : "'.
                $page.'").'
            );
        }

        $query = $this->createQueryBuilder('a')
            ->leftjoin('a.supplier', 's')
            ->addSelect('s')
            ->where('a.active = 1')
            ->orderBy('a.name', 'ASC')
            ->getQuery();

        // On définit l'article à partir duquel commencer la liste
        $query->setFirstResult(($page - 1) * $nbPerPage)
            // Ainsi que le nombre d'article à afficher
            ->setMaxResults($nbPerPage);

        // Et enfin, on retourne l'objet
        // Paginator correspondant à la requête construite
        return new Paginator($query);
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
