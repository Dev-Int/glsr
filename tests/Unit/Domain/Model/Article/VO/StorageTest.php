<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Model\Article\VO;

use Domain\Model\Article\VO\Storage;
use PHPUnit\Framework\TestCase;

class StorageTest extends TestCase
{
    final public function testInstantiateStorage(): void
    {
        // Arrange & Act
        $storage = Storage::fromArray(['Colis', 1]);

        // Assert
        $this->assertEquals(
            new Storage('colis', 1),
            $storage
        );
    }
}
