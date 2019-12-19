<?php

namespace Tests\Unit\Domain\Model\Article;

use Domain\Model\Article\Article;
use Domain\Model\Common\VO\NameField;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    final public function testInstantiateArticle(): void
    {
        // Arrange & Act
        $article = Article::create(
            NameField::fromString('Jambon Trad 6kg'),
            'Davigel',
            'KG',
            6.000,
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
                'Davigel',
                'KG',
                6.000,
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
        $article = Article::create(
            NameField::fromString('Jambon Trad 6kg'),
            'Davigel',
            'KG',
            6.000,
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
                'Davigel',
                'KG',
                6.000,
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
