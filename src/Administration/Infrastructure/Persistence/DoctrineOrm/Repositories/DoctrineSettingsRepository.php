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

use Administration\Application\Settings\ReadModel\Settings as SettingsReadModel;
use Administration\Domain\Protocol\Repository\SettingsRepositoryProtocol;
use Administration\Domain\Settings\Model\Settings;
use Administration\Domain\Settings\Model\VO\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineSettingsRepository extends ServiceEntityRepository implements SettingsRepositoryProtocol
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Settings::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    final public function add(Settings $settings): void
    {
        $this->getEntityManager()->persist($settings);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws ORMException
     */
    final public function remove(Settings $settings): void
    {
        $this->getEntityManager()->remove($settings);
    }

    /**
     * @throws NonUniqueResultException
     */
    final public function findOneByUuid(string $uuid): ?Settings
    {
        return $this->createQueryBuilder('ds')
            ->where('ds.uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @throws NonUniqueResultException
     */
    final public function findByLocale(string $locale): ?SettingsReadModel
    {
        $statement = $this->createQueryBuilder('ds')
            ->where('ds.locale = :locale')
            ->setParameter('locale', $locale)
            ->getQuery()
            ->getOneOrNullResult()
            ;
        if (null !== $statement) {
            \assert($statement instanceof Settings);

            return $this->createSettings($statement);
        }

        return null;
    }

    /**
     * @throws NonUniqueResultException
     */
    final public function findByCurrency(string $currency): ?SettingsReadModel
    {
        $statement = $this->createQueryBuilder('ds')
            ->where('ds.currency = :currency')
            ->setParameter('currency', $currency)
            ->getQuery()
            ->getOneOrNullResult()
        ;
        if (null !== $statement) {
            \assert($statement instanceof Settings);

            return $this->createSettings($statement);
        }

        return null;
    }

    /**
     * @throws NonUniqueResultException
     */
    final public function settingsExist(): bool
    {
        $statement = $this->createQueryBuilder('ds')
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return null !== $statement;
    }

    /**
     * @throws NonUniqueResultException
     */
    final public function findOne(): ?SettingsReadModel
    {
        $statement = $this->createQueryBuilder('ds')
            ->getQuery()
            ->getOneOrNullResult()
        ;
        if (null !== $statement) {
            \assert($statement instanceof Settings);

            return $this->createSettings($statement);
        }

        return null;
    }

    private function createSettings(Settings $statement): SettingsReadModel
    {
        $symbol = Currency::fromString($statement->currency());

        return new SettingsReadModel(
            $statement->currency(),
            $statement->locale(),
            $symbol->symbol(),
            $statement->uuid()
        );
    }
}
