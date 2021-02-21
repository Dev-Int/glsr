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

namespace Administration\Infrastructure\Finders\Doctrine;

use Administration\Application\Protocol\Finders\SettingsFinderProtocol;
use Administration\Application\Settings\ReadModel\Settings as SettingsReadModel;
use Administration\Infrastructure\Settings\Mapper\SettingsModelMapper;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class DoctrineSettingsFinder implements SettingsFinderProtocol
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function findOne(): ?SettingsReadModel
    {
        $query = $this->connection->createQueryBuilder()
            ->select('uuid', 'currency', 'locale')
            ->from('settings')
        ;
        $result = $query->execute()->fetchAssociative();

        if (false !== $result) {
            return (new SettingsModelMapper())->getReadModelFromArray($result);
        }

        return null;
    }

    /**
     * @throws Exception
     */
    public function findByLocale(string $locale): ?SettingsReadModel
    {
        $query = $this->connection->createQueryBuilder()
            ->select('uuid', 'currency', 'locale')
            ->from('settings')
            ->where('locale = :locale')
            ->setParameter('locale', $locale)
        ;
        $result = $query->execute()->fetchAssociative();

        if (false !== $result) {
            return (new SettingsModelMapper())->getReadModelFromArray($result);
        }

        return null;
    }

    /**
     * @throws Exception
     */
    public function findByCurrency(string $currency): ?SettingsReadModel
    {
        $query = $this->connection->createQueryBuilder()
            ->select('uuid', 'currency', 'locale')
            ->from('settings')
            ->where('currency = :currency')
            ->setParameter('currency', $currency)
        ;
        $result = $query->execute()->fetchAssociative();

        if (false !== $result) {
            return (new SettingsModelMapper())->getReadModelFromArray($result);
        }

        return null;
    }
}
