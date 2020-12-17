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

namespace Unit\Tests\Domain\Article\Model\Entities;

use Administration\Domain\Article\Model\Dependent\ZoneStorage;
use Core\Domain\Common\Model\VO\NameField;
use PHPUnit\Framework\TestCase;

class ZoneStorageTest extends TestCase
{
    final public function testInstantiateZoneStorage(): void
    {
        // Arrange && Act
        $zone = ZoneStorage::create(NameField::fromString('Réserve positive'));

        // Assert
        static::assertEquals(
            new ZoneStorage(NameField::fromString('Réserve positive')),
            $zone
        );
    }

    final public function testRenameZone(): void
    {
        // Arrange
        $zone = ZoneStorage::create(NameField::fromString('Réserve positive'));

        // Act
        $zone->renameZone(NameField::fromString('Réserve négative'));

        // Assert
        static::assertEquals(
            new ZoneStorage(NameField::fromString('Réserve négative')),
            $zone
        );
    }
}
