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

namespace Unit\Tests\Administration\Domain\FamilyLog\Model;

use Administration\Domain\FamilyLog\Model\FamilyLog;
use Administration\Domain\FamilyLog\Model\VO\FamilyLogUuid;
use Core\Domain\Common\Model\VO\NameField;
use PHPUnit\Framework\TestCase;

class FamilyLogTest extends TestCase
{
    final public function testInstantiateFamilyLog(): void
    {
        // Arrange & Act
        $surgele = FamilyLog::create(
            FamilyLogUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Surgelé'),
            FamilyLog::create(
                FamilyLogUuid::fromString('004c2842-4aab-4337-b359-e57cb9a72bb2'),
                NameField::fromString('Alimentaire')
            )
        );
        $familyLog = FamilyLog::create(
            FamilyLogUuid::fromString('626adfca-fc5d-415c-9b7a-7541030bd147'),
            NameField::fromString('Viande'),
            $surgele
        );

        // Assert
        self::assertEquals(
            new FamilyLog(
                FamilyLogUuid::fromString('626adfca-fc5d-415c-9b7a-7541030bd147'),
                NameField::fromString('Viande'),
                FamilyLog::create(
                    FamilyLogUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                    NameField::fromString('Surgelé'),
                    FamilyLog::create(
                        FamilyLogUuid::fromString('004c2842-4aab-4337-b359-e57cb9a72bb2'),
                        NameField::fromString('Alimentaire')
                    )
                )
            ),
            $familyLog
        );
        self::assertEquals('alimentaire:surgele:viande', $familyLog->path());
    }

    final public function testGetTreeFamilyLog(): void
    {
        // Arrange
        $alimentaire = FamilyLog::create(
            FamilyLogUuid::fromString('004c2842-4aab-4337-b359-e57cb9a72bb2'),
            NameField::fromString('Alimentaire')
        );
        $surgele = FamilyLog::create(
            FamilyLogUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Surgelé'),
            $alimentaire
        );
        FamilyLog::create(
            FamilyLogUuid::fromString('d425a8fb-5d42-4cc7-a540-2005360e36c2'),
            NameField::fromString('Frais'),
            $alimentaire
        );
        FamilyLog::create(
            FamilyLogUuid::fromString('626adfca-fc5d-415c-9b7a-7541030bd147'),
            NameField::fromString('Viande'),
            $surgele
        );

        // Act
        $tree = $alimentaire->parseTree();

        // Assert
        self::assertEquals(
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
