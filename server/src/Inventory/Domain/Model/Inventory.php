<?php

namespace Inventory\Domain\Model;

use Inventory\Domain\Model\VO\InventoryDate;

final class Inventory
{
    private \DateTimeImmutable $inventoryDate;
    private Articles $articles;

    public function __construct(InventoryDate $date, Articles $articles)
    {
        $this->inventoryDate = $date->getValue();
        $this->articles = $articles;
    }

    public static function prepare(InventoryDate $date, Articles $articles): self
    {
        return new self($date, $articles);
    }

    public function inventoryDate(): \DateTimeImmutable
    {
        return $this->inventoryDate;
    }

    public function articles(): Articles
    {
        return $this->articles;
    }

    public function enterInventoriedQuantity(Article $articleToUpdate, float $quantity): void
    {
        foreach ($this->articles->toArray() as $article) {
            if ($article->label() === $articleToUpdate->label()) {
                $article->updateStock($quantity);
            }
        }
    }

    public function getGaps(): array
    {
        $gaps = [];
        foreach ($this->articles->toArray() as $article) {
            $gaps[] = $article->gaps();
        }

        return $gaps;
    }
}
