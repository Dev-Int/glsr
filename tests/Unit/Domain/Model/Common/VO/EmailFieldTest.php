<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Model\Common\VO;

use Domain\Model\Common\InvalidEmail;
use Domain\Model\Common\VO\EmailField;
use PHPUnit\Framework\TestCase;

class EmailFieldTest extends TestCase
{
    final public function testCreateWithInvalidEmailThrowsADomainException(): void
    {
        // Arrange
        $this->expectException(InvalidEmail::class);

        // Act & Assert
        EmailField::fromString('invalid.email.fr');
    }
}
