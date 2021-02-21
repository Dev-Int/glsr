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

use Administration\Domain\Protocol\Repository\SettingsRepositoryProtocol;
use Administration\Domain\Settings\Model\Settings;
use Administration\Infrastructure\Settings\Mapper\SettingsModelMapper;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class DoctrineSettingsRepository implements SettingsRepositoryProtocol
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    final public function add(Settings $settings): void
    {
        $data = (new SettingsModelMapper())->getDataFromSettings($settings);

        $query = $this->connection->createQueryBuilder()
            ->insert('settings')
            ->values(['uuid' => '?', 'currency' => '?', 'locale' => '?'])
            ->setParameters([$data['uuid'], $data['currency'], $data['locale']])
        ;
        $query->execute();
    }

    /**
     * @throws Exception
     */
    final public function update(Settings $settings): void
    {
        $data = (new SettingsModelMapper())->getDataFromSettings($settings);

        $query = $this->connection->createQueryBuilder()
            ->update('settings')
            ->set('currency', '?')
            ->set('locale', '?')
            ->where('uuid = ?')
            ->setParameters([0 => $data['currency'], 1 => $data['locale'], 2 => $settings->uuid()])
        ;
        $query->execute();
    }

    /**
     * @throws Exception
     */
    final public function findOneByUuid(string $uuid): ?Settings
    {
        $query = $this->connection->createQueryBuilder()
            ->select('uuid', 'currency', 'locale')
            ->from('settings')
            ->where('uuid = ?')
            ->setParameter(0, $uuid)
        ;
        $result = $query->execute()->fetchAssociative();

        return (new SettingsModelMapper())->getDomainModelFromArray($result);
    }

    /**
     * @throws Exception
     */
    final public function exists(): bool
    {
        $query = $this->connection->createQueryBuilder()
            ->select('uuid')
            ->from('settings')
        ;

        $statement = $query->execute()->fetchAssociative();

        return false !== $statement;
    }
}
