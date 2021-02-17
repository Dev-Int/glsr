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

use Administration\Application\Company\ReadModel\Companies;
use Administration\Application\Company\ReadModel\Company as CompanyModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

interface CompanyFinderProtocol extends ServiceEntityRepositoryInterface
{
    public function findByUuid(string $uuid): CompanyModel;

    public function findAll(): Companies;
}
