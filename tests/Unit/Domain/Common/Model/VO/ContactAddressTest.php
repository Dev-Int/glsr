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

namespace Unit\Tests\Domain\Common\Model\VO;

use Core\Domain\Common\Model\VO\ContactAddress;
use PHPUnit\Framework\TestCase;

class ContactAddressTest extends TestCase
{
    final public function testInstantiateContactAddressFromArray(): void
    {
        // Arrange & Act
        $address = ContactAddress::fromArray([
            '2 rue de la truite',
            '75000',
            'Paris',
            'France',
        ]);

        // Assert
        static::assertEquals(
            new ContactAddress(
                '2 rue de la truite',
                '75000',
                'Paris',
                'France'
            ),
            $address
        );
    }

    final public function testInstantiateContactAddressFromString(): void
    {
        // Arrange & Act
        $address = ContactAddress::fromString(
            '2 rue de la truite
75000 Paris, France'
        );

        // Assert
        static::assertEquals(
            new ContactAddress(
                '2 rue de la truite',
                '75000',
                'Paris',
                'France'
            ),
            $address
        );
    }

    final public function testGetValueOfContactAddress(): void
    {
        // Arrange && Act
        $address = ContactAddress::fromArray([
            '2 rue de la truite',
            '75000',
            'Paris',
            'France',
        ]);

        // Assert
        static::assertEquals(
            '2 rue de la truite
75000 Paris, France',
            $address->getValue()
        );
    }
}
