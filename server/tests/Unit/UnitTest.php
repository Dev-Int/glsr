<?php

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