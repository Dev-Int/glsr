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

namespace Unit\Tests\Core\Domain\Common\Model\Dependent;

use Core\Domain\Common\Model\Dependent\Taxes;
use PHPUnit\Framework\TestCase;

class TaxesTest extends TestCase
{
    final public function testInstantiateTaxesFromFloat(): void
    {
        // Arrange & Act
        $taxes = Taxes::fromFloat(0.055);

        // Assert
        self::assertEquals(new Taxes(0.055), $taxes);
        self::assertEquals(0.055, $taxes->rate());
        self::assertEquals('5,50 %', $taxes->name());
    }

    final public function testInstantiateTaxesFromPercent(): void
    {
        // Arrange & Act
        $taxes = Taxes::fromPercent('5,50 %');

        // Assert
        self::assertEquals(new Taxes(0.055), $taxes);
        self::assertEquals(0.055, $taxes->rate());
        self::assertEquals('5,50 %', $taxes->name());
    }
}
