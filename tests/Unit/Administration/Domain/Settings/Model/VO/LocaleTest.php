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

use Administration\Domain\Settings\Model\VO\InvalidLocale;
use Administration\Domain\Settings\Model\VO\Locale;
use PHPUnit\Framework\TestCase;

class LocaleTest extends TestCase
{
    final public function testInstantiateLocale(): void
    {
        // Arrange && Act
        $currency = Locale::fromString('Fr');

        // Assert
        static::assertEquals(
            new Locale('Fr'),
            $currency
        );
    }

    final public function testInstantiateWithBadStringThrowDomainException(): void
    {
        // Arrange
        $this->expectException(InvalidLocale::class);

        // Act && Assert
        Locale::fromString('GB');
    }
}
