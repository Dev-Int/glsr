<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Model\Common\VO;

use Domain\Model\Common\StringExceeds255Characters;
use Domain\Model\Common\VO\NameField;
use PHPUnit\Framework\TestCase;

class NameFieldTest extends TestCase
{
    final public function testCreateWithNameTooLongThrowsADomainException(): void
    {
        // Arrange
        $this->expectException(StringExceeds255Characters::class);

        // Act & Assert
        NameField::fromString(str_repeat('a', 256));
    }

    final public function testSlugify(): void
    {
        // Arrange
        $name = NameField::fromString('Test slugify');

        // Act
        $slug = $name->slugify();

        // Assert
        $this->assertEquals('test-slugify', $slug);
    }
}
