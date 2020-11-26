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

namespace Tests\Unit\Domain\Model\Supplier;

use Domain\Model\Common\Entities\FamilyLog;
use Domain\Model\Common\VO\ContactAddress;
use Domain\Model\Common\VO\EmailField;
use Domain\Model\Common\VO\NameField;
use Domain\Model\Common\VO\PhoneField;
use Domain\Model\Supplier\Supplier;
use Domain\Model\Supplier\SupplierUuid;
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
                ContactAddress::fromString(
                    '15, rue des givrés',
                    '75000',
                    'Paris',
                    'France'
                ),
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
                ContactAddress::fromString(
                    '15, rue des givrés',
                    '75000',
                    'Paris',
                    'France'
                ),
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
