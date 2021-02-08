<?php

namespace App\Inventory\Domain;

final class Article
{
    private string $label;
    private float $theoreticalStock;
    private float $stock;
    private float $price;

    public function __construct(string $label, float $theoreticalStock, float $price)
    {
        $this->label = $label;
        $this->theoreticalStock = $theoreticalStock;
        $this->price = $price;
    }

    public static function create(string $label, float $theoreticalStock, float $price): self
    {
        return new self($label, $theoreticalStock, $price);
    }

    public function label(): string
    {
        return $this->label;
    }

    public function theoreticalStock(): float
    {
        return $this->theoreticalStock;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function updateStock(float $quantity): void
    {
        $this->stock = $quantity;
    }

    public function gaps(): array
    {
        return [
            'label' => $this->label,
            'gap' => $this->theoreticalStock - $this->stock,
            'amount' => ($this->theoreticalStock - $this->stock) * $this->price,
        ];
    }
}
