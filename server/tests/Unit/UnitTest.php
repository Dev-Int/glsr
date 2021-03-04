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

namespace Unit\Tests;

use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    final public function testUnit(): void
    {
        // Arrange && Act
        $test = true;

        // Assert
        self::assertTrue($test);
    }
}
