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

namespace Unit\Tests\Domain\Supplier\Model;

use Core\Domain\Common\Model\Dependent\FamilyLog;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;
use Domain\Supplier\Model\Supplier;
use Domain\Supplier\Model\SupplierUuid;
use PHPUnit\Framework\TestCase;

class SupplierTest extends TestCase
{
    final public function testInstantiateSupplier(): void
    {
        // Arrange & Act
        $supplier = Supplier::create(
            SupplierUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Davigel'),
            '15, rue des givrés',
            '75000',
            'Paris',
            'France',
            PhoneField::fromString('+33100000001'),
            PhoneField::fromString('+33100000002'),
            EmailField::fromString('contact@davigel.fr'),
            'David',
            PhoneField::fromString('+33600000001'),
            FamilyLog::create(NameField::fromString('Surgelé')),
            3,
            [1, 3]
        );

        // Assert
        static::assertEquals(
            new Supplier(
                SupplierUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Davigel'),
                '15, rue des givrés',
                '75000',
                'Paris',
                'France',
                PhoneField::fromString('+33100000001'),
                PhoneField::fromString('+33100000002'),
                EmailField::fromString('contact@davigel.fr'),
                'David',
                PhoneField::fromString('+33600000001'),
                FamilyLog::create(NameField::fromString('Surgelé')),
                3,
                [1, 3]
            ),
            $supplier
        );
    }

    final public function testRenameSupplier(): void
    {
        // Arrange
        $supplier = Supplier::create(
            SupplierUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Davigel'),
            '15, rue des givrés',
            '75000',
            'Paris',
            'France',
            PhoneField::fromString('+33100000001'),
            PhoneField::fromString('+33100000002'),
            EmailField::fromString('contact@davigel.fr'),
            'David',
            PhoneField::fromString('+33600000001'),
            FamilyLog::create(NameField::fromString('Surgelé')),
            3,
            [1, 3]
        );

        // Act
        $supplier->renameSupplier(NameField::fromString('Trans Gourmet'));

        // Assert
        static::assertEquals(
            new Supplier(
                SupplierUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Trans Gourmet'),
                '15, rue des givrés',
                '75000',
                'Paris',
                'France',
                PhoneField::fromString('+33100000001'),
                PhoneField::fromString('+33100000002'),
                EmailField::fromString('contact@davigel.fr'),
                'David',
                PhoneField::fromString('+33600000001'),
                FamilyLog::create(NameField::fromString('Surgelé')),
                3,
                [1, 3]
            ),
            $supplier
        );
    }
}
