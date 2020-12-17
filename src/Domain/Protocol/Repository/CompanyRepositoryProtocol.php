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

namespace Domain\Protocol\Repository;

use Administration\Domain\Company\Model\Company;

interface CompanyRepositoryProtocol
{
    public function existsWithName(string $name): bool;

    public function add(Company $company): void;

    public function remove(Company $company): void;

    public function findOneByUuid(string $uuid): ?Company;

    public function companyExist(): bool;
}
