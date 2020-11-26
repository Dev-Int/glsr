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

namespace Tests\Unit\Domain\Model\Article\Entities;

use Domain\Model\Article\Entities\ZoneStorage;
use Domain\Model\Common\VO\NameField;
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
