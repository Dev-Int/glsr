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

namespace Order\Domain\Model;

final class Article
{
    private string $label;
    private Supplier $supplier;
    private float $quantity;
    private float $minimumStock;
    private float $quantityToOrder;
    private float $price;

    public function __construct(
        string $label,
        Supplier $supplier,
        float $quantity,
        float $quantityToOrder,
        float $minimumStock,
        float $price
    ) {
        $this->label = $label;
        $this->supplier = $supplier;
        $this->price = $price;
        $this->quantity = $quantity;
        if (0.00 === $quantityToOrder) {
            $quantityToOrder = $minimumStock - $quantity;
        }
        $this->quantityToOrder = $quantityToOrder;
        $this->minimumStock = $minimumStock;
        $this->supplier->assignArticle($this);
    }

    public static function create(
        string $label,
        Supplier $supplier,
        float $quantity,
        float $quantityToOrder,
        float $minimumStock,
        float $price
    ): self {
        return new self($label, $supplier, $quantity, $quantityToOrder, $minimumStock, $price);
    }

    public function supplier(): Supplier
    {
        return $this->supplier;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function updateOrderedQuantity(float $quantity): void
    {
        $this->quantityToOrder = $quantity;
    }
}
