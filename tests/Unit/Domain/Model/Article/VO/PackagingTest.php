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

namespace Tests\Unit\Domain\Model\Article\VO;

use Domain\Model\Article\VO\Packaging;
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
        static::assertEquals(['colis', 1], $packages1->parcel());
        static::assertEquals(['poche', 4], $packages1->subPackage());
        static::assertEquals(['portion', 32], $packages1->consumerUnit());
        static::assertEquals(['colis', 1], $packages2->parcel());
        static::assertEquals(['poche', 4], $packages2->subPackage());
        static::assertNull($packages2->consumerUnit());
        static::assertEquals(['colis', 1], $packages3->parcel());
        static::assertNull($packages3->subPackage());
        static::assertEquals(['portion', 32], $packages3->consumerUnit());
        static::assertEquals(['colis', 1], $packages4->parcel());
        static::assertNull($packages4->subPackage());
        static::assertNull($packages4->consumerUnit());
    }
}
