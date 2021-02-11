<?php

namespace Inventory\Domain\UseCase;

use Inventory\Domain\Model\Inventory;

final class EnterInventory
{
    public function execute(Inventory $inventory, array $data): void
    {
        $articles = $inventory->articles();

        foreach ($data as $datum) {
            foreach ($articles->toArray() as $article) {
                if ($article->label() === $datum['label']) {
                    $article->updateStock($datum['stock']);
                }
            }
        }
    }
}
