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

namespace Unit\Tests\Order\Domain\Model\VO;

use Order\Domain\Exception\InvalidOrderDate;
use Order\Domain\Model\VO\OrderDate;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class OrderDateTest extends TestCase
{
    final public function testValueObjectCanBeInstantiateWithGoodDate(): void
    {
        // Arrange
        $dateToTest1 = new \DateTimeImmutable('2021-03-01'); // Monday
        $dateToTest2 = new \DateTimeImmutable('2021-03-04'); // Wednesday
        $arrayDays = [1, 4]; // Monday, Wednesday

        // Act
        $orderDate1 = OrderDate::fromDate($dateToTest1, $arrayDays);
        $orderDate2 = OrderDate::fromDate($dateToTest2, $arrayDays);

        // Assert
        Assert::assertEquals($dateToTest1, $orderDate1->getValue());
        Assert::assertEquals($dateToTest2, $orderDate2->getValue());
    }

    final public function testValueObjectCanBeInstantiateWithBadDateThrowsADomainException(): void
    {
        // Arrange
        $this->expectException(InvalidOrderDate::class);
        $dateToTest = new \DateTimeImmutable('2021-03-02'); // Tuesday
        $arrayDays = [1, 4]; // Monday, Wednesday

        // Act && Assert
        OrderDate::fromDate($dateToTest, $arrayDays);
    }
}
