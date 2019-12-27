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
        $familyLog = FamilyLog::create(
            NameField::fromString('Surgelé'),
            FamilyLog::create(NameField::fromString('Alimentaire'))
        );

        // Assert
        $this->assertEquals(
            new FamilyLog(
                NameField::fromString('Surgelé'),
                FamilyLog::create(NameField::fromString('Alimentaire'))
            ),
            $familyLog
        );
        $this->assertEquals('alimentaire_surgele', $familyLog->path());
    }

    final public function testGetTreeFamilyLog(): void
    {
        // Arrange
        $famAlim = FamilyLog::create(
            NameField::fromString('Alimentaire')
        );
        FamilyLog::create(
            NameField::fromString('Surgelé'),
            $famAlim
        );
        FamilyLog::create(
            NameField::fromString('Frais'),
            $famAlim
        );

        // Act
        $tree = $famAlim->parseTree();

        // Assert
        $this->assertEquals(
            [
                'Alimentaire' => [
                    'Surgelé',
                    'Frais',
                ],
            ],
            $tree
        );
    }
}
