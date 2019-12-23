<?php

declare(strict_types=1);

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
        $this->assertEquals($packages1->parcel(), ['colis', 1]);
        $this->assertEquals($packages1->subPackage(), ['poche', 4]);
        $this->assertEquals($packages1->consumerUnit(), ['portion', 32]);
        $this->assertEquals($packages2->parcel(), ['colis', 1]);
        $this->assertEquals($packages2->subPackage(), ['poche', 4]);
        $this->assertNull($packages2->consumerUnit());
        $this->assertEquals($packages3->parcel(), ['colis', 1]);
        $this->assertNull($packages3->subPackage());
        $this->assertEquals($packages3->consumerUnit(), ['portion', 32]);
        $this->assertEquals($packages4->parcel(), ['colis', 1]);
        $this->assertNull($packages4->subPackage());
        $this->assertNull($packages4->consumerUnit());
    }
}
