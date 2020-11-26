<?php

declare(strict_types=1);

/*
 * This file is part of the Tests package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Unit\Domain\Model\Common\VO;

use Domain\Model\Common\Exception\InvalidEmail;
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
