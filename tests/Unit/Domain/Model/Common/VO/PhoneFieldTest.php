<?php


namespace Tests\Unit\Domain\Model\Common\VO;


use Domain\Model\Common\InvalidPhone;
use Domain\Model\Common\VO\PhoneField;
use PHPUnit\Framework\TestCase;

class PhoneFieldTest extends TestCase
{
    final public function testInstantiatePhoneNumber(): void
    {
        // Arrange & Act
        $phone = PhoneField::fromString('+33179923223');

        // Assert
        $this->assertEquals(
            new PhoneField('+33179923223'),
            $phone
        );
    }

    final public function testCreateWithInvalidStringThrowADomainException(): void
    {
        // Arrange
        $this->expectException(InvalidPhone::class);

        // Act & Assert
        PhoneField::fromString('+55$32-55-78-85-62-49-21');
    }
}
