<?php

/**
 * Entité Supplier.
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
 * SupplierRepository Entité Supplier.
 *
 * @category Entity
 */
class SupplierRepository extends EntityRepository
{
    /**
     * Affiche les fournisseurs actifs.
     *
     * @return \Doctrine\ORM\QueryBuilder Requête DQL
     */
    public function getAllItems()
    {
        $query = $this->createQueryBuilder('s')
            ->join('s.familyLog', 'fl')
            ->addSelect('fl')
        ;
        
        return $query;
    }


    /**
     * Affiche les fournisseurs actifs.
     *
     * @return \Doctrine\ORM\QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems()
            ->where('s.active = 1')
        ;
        
        return $query;
    }

    /**
     * Renvoie les fournisseurs actifs correspondant à la famille logistique
     * de l'article en paramètre.
     *
     * @param AppBundle\Entity\Settings\Supplier $supplier Fournisseur sélectionné
     *
     * @return \Doctrine\ORM\QueryBuilder Requête DQL
     */
    public function getSupplierForReassign($supplier)
    {
        $query = $this->createQueryBuilder('s')
            ->select('s')
            ->where($query->expr()->neq('s.name', ':idname'))
            ->andWhere('s.familyLog = :flname')
            ->andWhere('s.active = true')
            ->setParameters(
                array(
                    'idname' => $supplier->getName(),
                    'flname' => $supplier->getFamilyLog(),
                )
            )
            ->orderBy('s.name', 'ASC');

        return $query;
    }
}
