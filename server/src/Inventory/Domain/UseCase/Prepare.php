<?php

namespace Inventory\Domain\UseCase;

use Inventory\Domain\Model\Article;
use Inventory\Domain\Model\Articles;
use Inventory\Domain\Model\Inventory;
use Inventory\Domain\Model\VO\InventoryDate;

final class Prepare
{
    public function execute(\DateTimeImmutable $date): Inventory
    {
        // get Articles
        $articles = new Articles(
            Article::create('tomato', 5.00, 0.85),
            Article::create('carotte', 0.00, 0.53),
            Article::create('potato', 0.00, 0.27),
        );

        return Inventory::prepare(InventoryDate::fromDate($date), $articles);
    }
}
