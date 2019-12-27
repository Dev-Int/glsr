<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Model\Common\Entities;

use Domain\Model\Common\Entities\FamilyLog;
use Domain\Model\Common\VO\NameField;
use PHPUnit\Framework\TestCase;

class FamilyLogTest extends TestCase
{
    final public function testInstantiateFamilyLog(): void
    {
        // Arrange & Act
        $surgele = FamilyLog::create(
            NameField::fromString('Surgelé'),
            FamilyLog::create(NameField::fromString('Alimentaire'))
        );
        $familyLog = FamilyLog::create(
            NameField::fromString('Viande'),
            $surgele
        );

        // Assert
        $this->assertEquals(
            new FamilyLog(
                NameField::fromString('Viande'),
                FamilyLog::create(
                    NameField::fromString('Surgelé'),
                    FamilyLog::create(
                        NameField::fromString('Alimentaire')
                    )
                )
            ),
            $familyLog
        );
        $this->assertEquals('alimentaire:surgele:viande', $familyLog->path());
    }

    final public function testGetTreeFamilyLog(): void
    {
        // Arrange
        $alimentaire = FamilyLog::create(
            NameField::fromString('Alimentaire')
        );
        $surgele = FamilyLog::create(
            NameField::fromString('Surgelé'),
            $alimentaire
        );
        FamilyLog::create(
            NameField::fromString('Frais'),
            $alimentaire
        );
        FamilyLog::create(
            NameField::fromString('Viande'),
            $surgele
        );

        // Act
        $tree = $alimentaire->parseTree();

        // Assert
        $this->assertEquals(
            [
                'Alimentaire' => [
                    'Surgelé' => [
                        'Viande',
                    ],
                    'Frais',
                ],
            ],
            $tree
        );
    }
}
