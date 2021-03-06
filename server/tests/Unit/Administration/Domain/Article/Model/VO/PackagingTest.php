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

use Administration\Domain\Article\Model\VO\Packaging;
use PHPUnit\Framework\TestCase;

class PackagingTest extends TestCase
{
    final public function testDistributeTheSubdivision(): void
    {
        // Arrange
        $array1 = [['colis', 1], ['poche', 4], ['portion', 32]];
        $array2 = [['colis', 1], ['poche', 4], null];
        $array3 = [['colis', 1], null, ['portion', 32]];
        $array4 = [['colis', 1], null, null];

        // Act
        $packages1 = Packaging::fromArray($array1);
        $packages2 = Packaging::fromArray($array2);
        $packages3 = Packaging::fromArray($array3);
        $packages4 = Packaging::fromArray($array4);

        // Assert
        self::assertEquals(['colis', 1], $packages1->parcel());
        self::assertEquals(['poche', 4], $packages1->subPackage());
        self::assertEquals(['portion', 32], $packages1->consumerUnit());
        self::assertEquals(['colis', 1], $packages2->parcel());
        self::assertEquals(['poche', 4], $packages2->subPackage());
        self::assertNull($packages2->consumerUnit());
        self::assertEquals(['colis', 1], $packages3->parcel());
        self::assertNull($packages3->subPackage());
        self::assertEquals(['portion', 32], $packages3->consumerUnit());
        self::assertEquals(['colis', 1], $packages4->parcel());
        self::assertNull($packages4->subPackage());
        self::assertNull($packages4->consumerUnit());
    }
}
