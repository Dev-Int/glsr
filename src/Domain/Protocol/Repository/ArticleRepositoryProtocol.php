<?php

declare(strict_types=1);

namespace Domain\Protocol\Repository;

use Domain\Model\Article\Article;

interface ArticleRepositoryProtocol
{
    /**
     * Save the Article object in the database.
     * @param Article $article
     */
    public function save(Article $article): void;

    /**
     * Delete the Article object in the database.
     * @param Article $article
     */
    public function remove(Article $article): void;
}
