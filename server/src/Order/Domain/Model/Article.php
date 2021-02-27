<?php

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
