<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Model\Article;

use Domain\Model\Article\Article;
use Domain\Model\Article\VO\Packaging;
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
            'Surgelé',
            3,
            [1, 3]
        );

        //Act
        $article = Article::create(
            NameField::fromString('Jambon Trad 6kg'),
            $supplier,
            Packaging::fromArray([['Colis', 1], ['pièce', 2], ['kilogramme', 6.000]]),
            6.82,
            '10%',
            8.8,
            ['Chambre positive'],
            'Frais:Viande'
        );

        // Assert
        $this->assertEquals(
            new Article(
                NameField::fromString('Jambon Trad 6kg'),
                $supplier,
                Packaging::fromArray([['Colis', 1], ['pièce', 2], ['kilogramme', 6.000]]),
                6.82,
                '10%',
                8.8,
                ['Chambre positive'],
                'Frais:Viande'
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
            'Surgelé',
            3,
            [1, 3]
        );
        $article = Article::create(
            NameField::fromString('Jambon Trad 6kg'),
            $supplier,
            Packaging::fromArray([['Colis', 1], ['pièce', 2], ['kilogramme', 6.000]]),
            6.82,
            '10%',
            8.8,
            ['Chambre positive'],
            'Frais:Viande'
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
                '10%',
                8.8,
                ['Chambre positive'],
                'Frais:Viande'
            ),
            $article
        );
    }
}
