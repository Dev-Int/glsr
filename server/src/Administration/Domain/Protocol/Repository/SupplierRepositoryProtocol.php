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
    /**
     * Save the Supplier object in the data storage.
     */
    public function save(Supplier $article): void;

    /**
     * Delete the Supplier object in the data storage.
     */
    public function remove(Supplier $article): void;
}
