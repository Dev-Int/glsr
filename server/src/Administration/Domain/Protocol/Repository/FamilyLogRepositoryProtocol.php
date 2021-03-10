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

use Administration\Domain\FamilyLog\Model\FamilyLog;

interface FamilyLogRepositoryProtocol
{
    public function add(FamilyLog $familyLog): void;

    public function findParent(string $uuid): FamilyLog;

    public function existWithLabel(string $label, ?string $parentUuid): bool;
}
