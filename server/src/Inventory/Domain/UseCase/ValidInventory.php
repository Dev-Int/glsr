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

namespace Inventory\Domain\UseCase;

use Inventory\Domain\Model\Article;
use Inventory\Domain\Model\Inventory;

final class ValidInventory
{
    public function execute(Inventory $inventory): void
    {
        $articles = $inventory->articles()->toArray();

        \array_map(static function (Article $article): void {
            $article->validStock();
        }, $articles);
    }
}
