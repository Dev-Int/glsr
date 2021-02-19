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

namespace Administration\Infrastructure\Settings\Handler;

use Administration\Application\Settings\ReadModel\Settings as SettingsReadModel;
use Administration\Infrastructure\Finders\Doctrine\DoctrineSettingsFinder;
use Administration\Infrastructure\Settings\Query\GetSettings;
use Core\Domain\Protocol\Common\Query\QueryHandlerProtocol;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;

class GetSettingsHandler implements QueryHandlerProtocol
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function __invoke(GetSettings $query): ?SettingsReadModel
    {
        if (null === $query->currency() && null === $query->locale()) {
            return (new DoctrineSettingsFinder($this->connection))
                ->findOne()
            ;
        }
        if (null !== $query->locale()) {
            return (new DoctrineSettingsFinder($this->connection))
                ->findByLocale($query->locale())
            ;
        }
        if (null !== $query->currency()) {
            return (new DoctrineSettingsFinder($this->connection))
                ->findByCurrency($query->currency())
            ;
        }

        return null;
    }
}
