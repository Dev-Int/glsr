<?php

/**
 * Entity Supplier.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @see https://github.com/Dev-Int/glsr
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
     * Returns the active providers corresponding to the logistic family
     * of the article in parameter.
     *
     * @param \App\Entity\Settings\Supplier $supplier Selected supplier
     *
     * @return \Doctrine\ORM\QueryBuilder DQL query
     */
    public function getSupplierForReassign($supplier)
    {
        $query = $this->createQueryBuilder('s');
        $query
            ->select('s')
            ->where($query->expr()->neq('s.name', ':idname'))
            ->andWhere('s.familyLog = :flname')
            ->andWhere('s.active = true')
            ->setParameters(['idname' => $supplier->getName(), 'flname' => $supplier->getFamilyLog()])
            ->orderBy('s.name', 'ASC');

        return $query;
    }
}
