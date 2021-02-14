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

namespace Administration\Infrastructure\Finders\DoctrineOrm;

use Administration\Application\FamilyLog\ReadModel\FamilyLog as FamilyLogModel;
use Administration\Application\FamilyLog\ReadModel\FamilyLogs;
use Administration\Application\Protocol\Finders\FamilyLogFinderProtocol;
use Administration\Domain\FamilyLog\Model\FamilyLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineFamilyLogFinder extends ServiceEntityRepository implements FamilyLogFinderProtocol
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamilyLog::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findBySlug(string $slug): FamilyLogModel
    {
        $result = $this->createQueryBuilder('fl')
            ->where('fl.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return new FamilyLogModel(
            $result->name(),
            $result->parent(),
            $result->children(),
            $result->path(),
            $result->slug()
        );
    }

    public function findAll(): FamilyLogs
    {
        $statement = $this->createQueryBuilder('fl')
            ->getQuery()
            ->getResult()
        ;

        return new FamilyLogs(
            ...\array_map(static function (FamilyLog $familyLog) {
                return new FamilyLogModel(
                    $familyLog->name(),
                    $familyLog->parent(),
                    $familyLog->children(),
                    $familyLog->path(),
                    $familyLog->slug()
                );
            }, $statement)
        );
    }
}
