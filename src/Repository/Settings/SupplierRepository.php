<?php

namespace App\Repository\Settings;

use App\Entity\Settings\Supplier;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

final class SupplierRepository extends EntityRepository
{
    /**
     * Returns the active providers corresponding to the logistic family
     * of the article in parameter.
     */
    public function getSupplierForReassign(Supplier $supplier): QueryBuilder
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
