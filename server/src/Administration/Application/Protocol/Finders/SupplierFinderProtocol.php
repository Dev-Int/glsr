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

use Administration\Application\Supplier\ReadModel\Supplier as SupplierModel;
use Administration\Application\Supplier\ReadModel\Suppliers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

interface SupplierFinderProtocol extends ServiceEntityRepositoryInterface
{
    public function findOneByUuid(string $uuid): SupplierModel;

    public function findAllActive(): Suppliers;
}
