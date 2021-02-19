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

namespace Administration\Application\Protocol\Finders;

use Administration\Application\Settings\ReadModel\Settings as SettingsReadModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

interface SettingsFinderProtocol extends ServiceEntityRepositoryInterface
{
    public function findOne(): ?SettingsReadModel;

    public function findByLocale(string $locale): ?SettingsReadModel;

    public function findByCurrency(string $currency): ?SettingsReadModel;
}
