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

namespace Unit\Tests\Administration\Domain\Settings\Model\VO;

use Company\Domain\Model\VO\Currency;
use Company\Domain\Model\VO\InvalidCurrency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    final public function testInstantiateCurrency(): void
    {
        // Arrange && Act
        $currency = Currency::fromString('Euro');

        // Assert
        self::assertEquals(
            new Currency('Euro'),
            $currency
        );
    }

    final public function testInstantiateWithBadStringThrowDomainException(): void
    {
        // Arrange
        $this->expectException(InvalidCurrency::class);

        // Act && Assert
        Currency::fromString('GB');
    }
}
