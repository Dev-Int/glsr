<?php

/**
 * Entity Supplier.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace App\Repository\Settings;

use App\Entity\Settings\Supplier;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * SupplierRepository Entity.
 *
 * @category Entity
 */
class SupplierRepository extends EntityRepository
{
    /**
     * Returns the active providers corresponding to the logistic family
     * of the article in parameter.
     *
     * @param Supplier $supplier Selected supplier
     *
     * @return QueryBuilder DQL query
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
