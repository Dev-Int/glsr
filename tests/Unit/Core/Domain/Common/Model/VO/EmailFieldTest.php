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

namespace Unit\Tests\Core\Domain\Common\Model\VO;

use Core\Domain\Common\Model\Exception\InvalidEmail;
use Core\Domain\Common\Model\VO\EmailField;
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
