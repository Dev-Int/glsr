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

namespace Tests\Unit\Domain\Model\Common\VO;

use Domain\Model\Common\VO\ContactAddress;
use PHPUnit\Framework\TestCase;

class ContactAddressTest extends TestCase
{
    final public function testInstantiateContactAddress(): void
    {
        // Arrange & Act
        $address = ContactAddress::fromString(
            '2, rue de la truite',
            '75000',
            'Paris',
            'France'
        );

        // Assert
        static::assertEquals(
            new ContactAddress(
                '2, rue de la truite',
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
        $address = ContactAddress::fromString(
            '2, rue de la truite',
            '75000',
            'Paris',
            'France'
        );

        // Assert
        static::assertEquals(
            '2, rue de la truite
75000 Paris, France',
            $address->getValue()
        );
    }
}
