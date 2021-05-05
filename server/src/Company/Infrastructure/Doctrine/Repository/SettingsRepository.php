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

namespace Company\Infrastructure\Doctrine\Repository;

use Company\Domain\Model\VO\Currency;
use Company\Domain\Model\VO\Locale;
use Company\Domain\Storage\Settings\SettingsEntity;
use Company\Infrastructure\Doctrine\Entity\Settings;
use Core\Domain\Common\Model\VO\ResourceUuid;
use Core\Domain\Common\Model\VO\ResourceUuidInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Settings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Settings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Settings[]    findAll()
 * @method Settings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Settings::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(SettingsEntity $settings): void
    {
        $this->getEntityManager()->persist($settings);
        $this->flush();
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @throws ORMException
     */
    public function remove(SettingsEntity $settings): void
    {
        $this->getEntityManager()->remove($settings);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByUuid(ResourceUuidInterface $uuid): ?Settings
    {
        return $this->createQueryBuilder('ds')
            ->where('ds.uuid = :uuid')
            ->setParameter('uuid', ResourceUuid::fromUuid($uuid))
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByLocale(Locale $locale): ?Settings
    {
        return $this->createQueryBuilder('ds')
            ->where('ds.locale = :locale')
            ->setParameter('locale', Locale::fromLocale($locale))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByCurrency(Currency $currency): ?Settings
    {
        return $this->createQueryBuilder('ds')
            ->where('ds.currency = :currency')
            ->setParameter('currency', Currency::fromCurrency($currency))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function settingsExists(): bool
    {
        $statement = $this->createQueryBuilder('ds')
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return null !== $statement;
    }

    /**
     * @throws NonUniqueResultException
     * @Todo Replaced by findDefaultSettings
     */
    public function findOne(): ?Settings
    {
        return $this->createQueryBuilder('ds')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
