<?php

namespace App\Inventory\Infrastructure;

use App\Inventory\Domain\Articles;
use App\Inventory\Domain\Inventory;
use App\Inventory\Domain\VO\InventoryDate;

final class InventoryController
{
    public function prepare(\DateTimeImmutable $inventoryDate): Inventory
    {
        // get Articles
        $articles = new Articles();

        return Inventory::prepare(
            InventoryDate::fromDate($inventoryDate),
            $articles
        );
    }
}
