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
use Administration\Domain\Settings\Model\VO\Currency;
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
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    public function findOne(): ?SettingsReadModel
    {
        $query = <<<'SQL'
SELECT
    settings.uuid as uuid,
    settings.currency as currency,
    settings.locale as locale
FROM settings
SQL;
        $result = $this->connection->executeQuery($query)->fetchAssociative();

        if (false !== $result) {
            return $this->createSettings($result);
        }

        return null;
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    public function findByLocale(string $locale): ?SettingsReadModel
    {
        $query = <<<'SQL'
SELECT
    settings.uuid as uuid,
    settings.currency as currency,
    settings.locale as locale
FROM settings
WHERE locale = :locale
SQL;
        $result = $this->connection->executeQuery($query, ['locale' => $locale])->fetchAssociative();

        if (false !== $result) {
            return $this->createSettings($result);
        }

        return null;
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    public function findByCurrency(string $currency): ?SettingsReadModel
    {
        $query = <<<'SQL'
SELECT
    settings.uuid as uuid,
    settings.currency as currency,
    settings.locale as locale
FROM settings
WHERE currency = :currency
SQL;
        $result = $this->connection->executeQuery($query, ['currency' => $currency])->fetchAssociative();

        if (false !== $result) {
            return $this->createSettings($result);
        }

        return null;
    }

    private function createSettings(array $result): SettingsReadModel
    {
        $symbol = Currency::fromString($result['currency']);

        return new SettingsReadModel(
            $result['currency'],
            $result['locale'],
            $symbol->symbol(),
            $result['uuid']
        );
    }
}
