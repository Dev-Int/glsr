<?php

declare(strict_types=1);

/*
 * This file is part of the G.L.S.R. Apps package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Administration\Infrastructure\Persistence\DoctrineOrm\Repositories;

use Administration\Domain\FamilyLog\Model\FamilyLog;
use Administration\Domain\Protocol\Repository\FamilyLogRepositoryProtocol;
use Administration\Infrastructure\Finders\Exceptions\FamilyLogNotFound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineFamilyLogRepository extends ServiceEntityRepository implements FamilyLogRepositoryProtocol
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamilyLog::class);
    }

    /**
     * @throws ORMException
     */
    public function add(FamilyLog $familyLog): void
    {
        $this->getEntityManager()->persist($familyLog);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByUuid(string $uuid): FamilyLog
    {
        $result = $this->createQueryBuilder('fl')
            ->where('fl.uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (null === $result) {
            throw new FamilyLogNotFound();
        }

        return $result;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function existWithLabel(string $label, ?string $parentUuid): bool
    {
        $resultParent = false;
        $statement = $this->createQueryBuilder('fl')
            ->select(['1'])
            ->where('fl.label = :label')
            ->setParameter('label', $label)
            ->getQuery()
            ->getOneOrNullResult()
        ;
        $result = !(null === $statement);

        if (null !== $parentUuid) {
            $parent = $this->findByUuid($parentUuid);
            if (null !== $parent->children()) {
                $resultParent = \in_array($label, $parent->children(), true);
            }
        }

        return null === $result && false === $resultParent;
    }
}
