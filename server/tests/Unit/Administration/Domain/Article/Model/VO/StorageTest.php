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

namespace Unit\Tests\Administration\Domain\Article\Model\VO;

use Administration\Domain\Article\Model\VO\Storage;
use PHPUnit\Framework\TestCase;

class StorageTest extends TestCase
{
    final public function testInstantiateStorage(): void
    {
        // Arrange & Act
        $storage = Storage::fromArray(['Colis', 1]);

        // Assert
        self::assertEquals(
            new Storage('colis', 1),
            $storage
        );
    }
}
