<?php

declare(strict_types=1);

/*
 * This file is part of the  G.L.S.R. Apps package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Domain\Protocol\Repository;

use Domain\Model\Article\Article;

interface ArticleRepositoryProtocol
{
    /**
     * Save the Article object in the data storage.
     */
    public function save(Article $article): void;

    /**
     * Delete the Article object in the data storage.
     */
    public function remove(Article $article): void;
}
