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

namespace Unit\Tests\Administration\Domain\Article\Model;

use Administration\Domain\Article\Model\Article;
use Administration\Domain\Article\Model\Dependent\ZoneStorage;
use Administration\Domain\Article\Model\VO\ArticleUuid;
use Administration\Domain\Article\Model\VO\Packaging;
use Administration\Domain\Supplier\Model\Supplier;
use Administration\Domain\Supplier\Model\VO\SupplierUuid;
use Core\Domain\Common\Model\Dependent\FamilyLog;
use Core\Domain\Common\Model\Dependent\Taxes;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    final public function testInstantiateArticle(): void
    {
        // Arrange && Act
        $article = Article::create(
            ArticleUuid::fromString('e5b6c68b-23d0-4e4e-ad5e-436c649da004'),
            NameField::fromString('Jambon Trad 6kg'),
            $this->getSupplier(),
            Packaging::fromArray([['Colis', 1], ['pièce', 2], ['kilogramme', 6.000]]),
            6.82,
            Taxes::fromFloat(5.5),
            8.8,
            [$this->getZoneStorage()],
            FamilyLog::create(
                NameField::fromString('Viande'),
                FamilyLog::create(NameField::fromString('Frais'))
            )
        );

        // Assert
        self::assertEquals(
            new Article(
                ArticleUuid::fromString('e5b6c68b-23d0-4e4e-ad5e-436c649da004'),
                NameField::fromString('Jambon Trad 6kg'),
                $this->getSupplier(),
                Packaging::fromArray([['Colis', 1], ['pièce', 2], ['kilogramme', 6.000]]),
                6.82,
                Taxes::fromFloat(5.5),
                8.8,
                [$this->getZoneStorage()],
                FamilyLog::create(
                    NameField::fromString('Viande'),
                    FamilyLog::create(NameField::fromString('Frais'))
                )
            ),
            $article
        );
    }

    final public function testRenameArticle(): void
    {
        // Arrange
        $article = Article::create(
            ArticleUuid::fromString('e5b6c68b-23d0-4e4e-ad5e-436c649da004'),
            NameField::fromString('Jambon Trad 6kg'),
            $this->getSupplier(),
            Packaging::fromArray([['Colis', 1], ['pièce', 2], ['kilogramme', 6.000]]),
            6.82,
            Taxes::fromFloat(5.5),
            8.8,
            [$this->getZoneStorage()],
            FamilyLog::create(
                NameField::fromString('Viande'),
                FamilyLog::create(NameField::fromString('Frais'))
            )
        );

        // Act
        $article->renameArticle(NameField::fromString('Jambon Tradition 6kg'));

        // Assert
        self::assertEquals(
            new Article(
                ArticleUuid::fromString('e5b6c68b-23d0-4e4e-ad5e-436c649da004'),
                NameField::fromString('Jambon Tradition 6kg'),
                $this->getSupplier(),
                Packaging::fromArray([['Colis', 1], ['pièce', 2], ['kilogramme', 6.000]]),
                6.82,
                Taxes::fromFloat(5.5),
                8.8,
                [$this->getZoneStorage()],
                FamilyLog::create(
                    NameField::fromString('Viande'),
                    FamilyLog::create(NameField::fromString('Frais'))
                )
            ),
            $article
        );
    }

    private function getZoneStorage(): ZoneStorage
    {
        return ZoneStorage::create(NameField::fromString('Chambre positive'));
    }

    private function getSupplier(): Supplier
    {
        return Supplier::create(
            SupplierUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Davigel'),
            '15, rue des givrés',
            '75000',
            'Paris',
            'France',
            PhoneField::fromString('+33100000001'),
            PhoneField::fromString('+33100000002'),
            EmailField::fromString('contact@davigel.fr'),
            'David',
            PhoneField::fromString('+33600000001'),
            FamilyLog::create(NameField::fromString('Frais')),
            3,
            [1, 3]
        );
    }
}
