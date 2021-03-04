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

        if (0.00 !== $gap) {
            return [
                'label' => $this->label,
                'gap' => $gap,
                'amount' => $gap * $this->price,
            ];
        }

        return null;
    }

    public function validStock(): void
    {
        $this->theoreticalStock = $this->stock;
        $this->stock = 0.0;
    }
}
