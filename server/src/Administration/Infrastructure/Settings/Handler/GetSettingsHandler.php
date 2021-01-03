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

use Administration\Application\Settings\ReadModel\Settings;
use Administration\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineSettingsRepository;
use Administration\Infrastructure\Settings\Query\GetSettings;
use Core\Domain\Protocol\Common\Query\QueryHandlerProtocol;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class GetSettingsHandler implements QueryHandlerProtocol
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function __invoke(GetSettings $query): ?Settings
    {
        if (null === $query->currency() && null === $query->locale()) {
            return (new DoctrineSettingsRepository($this->registry))
                ->findOne()
            ;
        }
        if (null !== $query->locale()) {
            return (new DoctrineSettingsRepository($this->registry))
                ->findByLocale($query->locale())
            ;
        }
        if (null !== $query->currency()) {
            return (new DoctrineSettingsRepository($this->registry))
                ->findByCurrency($query->currency())
            ;
        }

        return null;
    }
}
