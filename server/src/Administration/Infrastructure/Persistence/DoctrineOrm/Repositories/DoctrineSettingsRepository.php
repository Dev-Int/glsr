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
use Administration\Domain\Settings\Model\VO\Currency;
use Administration\Domain\Settings\Model\VO\Locale;
use Administration\Domain\Settings\Model\VO\SettingsUuid;
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
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    final public function add(Settings $settings): void
    {
        $data = $this->getData($settings);

        $statement = $this->connection->prepare(
            'INSERT INTO settings
(uuid, currency, locale) VALUES (:uuid, :currency, :locale)'
        );
        $statement->execute($data);
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    final public function update(Settings $settings): void
    {
        $data = $this->getData($settings);

        $statement = $this->connection->prepare(
            'UPDATE settings SET
uuid = :uuid, currency = :currency, locale = :locale
WHERE uuid = :uuid'
        );
        $statement->execute($data);
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    final public function findOneByUuid(string $uuid): ?Settings
    {
        $query = <<<'SQL'
SELECT
    settings.uuid as uuid,
    settings.currency as currency,
    settings.locale as locale
FROM settings
WHERE uuid = :uuid
SQL;
        $result = $this->connection->executeQuery($query, ['uuid' => $uuid])->fetchAssociative();

        return Settings::create(
            SettingsUuid::fromString($result['uuid']),
            Locale::fromString($result['locale']),
            Currency::fromString($result['currency'])
        );
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    final public function settingsExist(): bool
    {
        $query = <<<'SQL'
SELECT uuid FROM settings
SQL;

        $statement = $this->connection->executeQuery($query)->fetchAssociative();

        return false !== $statement;
    }

    private function getData(Settings $settings): array
    {
        return [
            'uuid' => $settings->uuid(),
            'locale' => $settings->locale(),
            'currency' => $settings->currency(),
        ];
    }
}
