<?php

/**
 * Inventory Entité.
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
namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * InventoryRepository.
 *
 * @category   Entity
 */
class InventoryRepository extends EntityRepository
{
    /**
     * getActive Renvoie les inventaires actifs.
     *
     * @return array Query result
     */
    public function getActive()
    {
        $query = $this->createQueryBuilder('i')
            ->addSelect('i')
            ->where('i.active > 0')
            ->orderBy('i.date', 'DESC')
            ->getQuery();

        return $query->getResult();
    }
    /**
     * Affiche les articles de l'inventaire, avec une pagination.
     *
     * @param Inventory $inventory Inventaire recherché
     * @param int $nbPerPage Nombre d'article par page
     * @param int $page      Numéro de la page en cours
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator Objet Paginator
     *
     * @throws \InvalidArgumentException
     */
    public function getInventoryArticles(Inventory $inventory, $nbPerPage, $page)
    {
        if ($page < 1) {
            throw new \InvalidArgumentException(
                'l\'argument $page ne peut être inférieur à 1 (valeur : "'.
                $page.'").'
            );
        }

        $query = $this->createQueryBuilder('i')
            ->leftJoin('i.articles', 'a')
            ->select('a')
            ->where('i.idInv = :id')
            ->setParameter('id', $inventory)
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
    
    public function getCountArticles()
    {
        $query = $this->createQueryBuilder('i')
            ->join('i.articles', 'a')
            ->select('COUNT(a)')
            ->groupBy('i.idInv')
            ->getQuery();
        return $query->getResult();
    }
}
