<?php

namespace Tests\Unit\Domain\Model\Article;

use Domain\Model\Article\Article;
use Domain\Model\Common\Name;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    final public function testInstantiateArticle(): void
    {
        // Arrange & Act
        $article = Article::create(
            Name::fromString('Jambon Trad 6kg'),
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
                Name::fromString('Jambon Trad 6kg'),
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
            Name::fromString('Jambon Trad 6kg'),
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
        $article->renameArticle(Name::fromString('Jambon Tradition 6kg'));

        // Assert
        $this->assertEquals(
            new Article(
                Name::fromString('Jambon Tradition 6kg'),
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
