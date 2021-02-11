<?php

namespace Inventory\Domain\Model;

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
        $this->stock = 0.00;
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

    public function price(): float
    {
        return $this->price;
    }

    public function updateStock(float $quantity): void
    {
        $this->stock = $quantity;
    }

    public function gap(): ?array
    {
        $gap = $this->theoreticalStock - $this->stock;

        if ($gap !== 0.00) {
            return [
                'label' => $this->label,
                'gap' => $gap,
                'amount' => $gap * $this->price,
            ];
        }

        return null;
    }
}
