<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Model\Article;

use Domain\Model\Article\Article;
use Domain\Model\Article\VO\Packaging;
use Domain\Model\Common\Entities\FamilyLog;
use Domain\Model\Common\Entities\Taxes;
use Domain\Model\Common\VO\EmailField;
use Domain\Model\Common\VO\NameField;
use Domain\Model\Common\VO\PhoneField;
use Domain\Model\Supplier\Supplier;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    final public function testInstantiateArticle(): void
    {
        // Arrange
        $supplier = Supplier::create(
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

        //Act
        $article = Article::create(
            NameField::fromString('Jambon Trad 6kg'),
            $supplier,
            Packaging::fromArray([['Colis', 1], ['pièce', 2], ['kilogramme', 6.000]]),
            6.82,
            Taxes::fromFloat(5.5),
            8.8,
            ['Chambre positive'],
            FamilyLog::create(
                NameField::fromString('Viande'),
                FamilyLog::create(NameField::fromString('Frais'))
            )
        );

        // Assert
        $this->assertEquals(
            new Article(
                NameField::fromString('Jambon Trad 6kg'),
                $supplier,
                Packaging::fromArray([['Colis', 1], ['pièce', 2], ['kilogramme', 6.000]]),
                6.82,
                Taxes::fromFloat(5.5),
                8.8,
                ['Chambre positive'],
                FamilyLog::create(
                    NameField::fromString('Viande'),
                    FamilyLog::create(NameField::fromString('Frais'))
                )
            ),
            $article
        );
    }

    final public function testChangeName(): void
    {
        // Arrange
        $supplier = Supplier::create(
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
        $article = Article::create(
            NameField::fromString('Jambon Trad 6kg'),
            $supplier,
            Packaging::fromArray([['Colis', 1], ['pièce', 2], ['kilogramme', 6.000]]),
            6.82,
            Taxes::fromFloat(5.5),
            8.8,
            ['Chambre positive'],
            FamilyLog::create(
                NameField::fromString('Viande'),
                FamilyLog::create(NameField::fromString('Frais'))
            )
        );

        // Act
        $article->renameArticle(NameField::fromString('Jambon Tradition 6kg'));

        // Assert
        $this->assertEquals(
            new Article(
                NameField::fromString('Jambon Tradition 6kg'),
                $supplier,
                Packaging::fromArray([['Colis', 1], ['pièce', 2], ['kilogramme', 6.000]]),
                6.82,
                Taxes::fromFloat(5.5),
                8.8,
                ['Chambre positive'],
                FamilyLog::create(
                    NameField::fromString('Viande'),
                    FamilyLog::create(NameField::fromString('Frais'))
                )
            ),
            $article
        );
    }
}
