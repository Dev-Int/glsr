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

namespace Administration\Domain\Protocol\Repository;

use Administration\Domain\Supplier\Model\Supplier;

interface SupplierRepositoryProtocol
{
    public function existsWithName(string $name): bool;

    public function add(Supplier $supplier): void;

    public function update(Supplier $supplier): void;

    public function findOneByUuid(string $uuid): Supplier;
}
