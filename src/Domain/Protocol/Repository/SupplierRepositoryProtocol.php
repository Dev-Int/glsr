<?php

declare(strict_types=1);

/*
 * This file is part of the Tests package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Domain\Protocol\Repository;

use Domain\Model\Supplier\Supplier;

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
