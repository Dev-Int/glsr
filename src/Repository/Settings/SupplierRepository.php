<?php

/**
 * Entity Supplier.
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
 * SupplierRepository Entity.
 *
 * @category Entity
 */
class SupplierRepository extends EntityRepository
{
    /**
     * Displays all suppliers.
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
     * Displays active suppliers.
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
     * Returns the active suppliers matching logistic family of the article in parameter.
     *
     * @param App\Entity\Settings\Supplier $supplier Selected supplier
     *
     * @return \Doctrine\ORM\QueryBuilder Requête DQL
     */
    public function getSupplierForReassign($supplier)
    {
        $query = $this->createQueryBuilder('s');
        $query
            ->select('s')
            ->where($query->expr()->neq('s.name', ':idname'))
            ->andWhere('s.familyLog = :flname')
            ->andWhere('s.active = true')
            ->setParameters(['idname' => $supplier->getName(), 'flname' => $supplier->getFamilyLog(),])
            ->orderBy('s.name', 'ASC');

        return $query;
    }
}
