<?php

namespace Inventory\Domain\UseCase;

use Inventory\Domain\Model\Article;
use Inventory\Domain\Model\Inventory;

final class ValidInventory
{
    public function execute(Inventory $inventory): void
    {
        $articles = $inventory->articles()->toArray();

        array_map(static function (Article $article) {
            $article->validStock();
        }, $articles);
    }
}
