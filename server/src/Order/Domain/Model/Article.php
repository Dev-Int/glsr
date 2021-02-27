<?php

namespace Order\Domain\Model;

final class Article
{
    private string $label;
    private Supplier $supplier;
    private float $price;

    public function __construct(string $label, Supplier $supplier, float $price)
    {
        $this->label = $label;
        $this->supplier = $supplier;
        $this->price = $price;
        $this->supplier->assignArticle($this);
    }

    public static function create(string $label, Supplier $supplier, float $price): self
    {
        return new self($label, $supplier, $price);
    }

    public function supplier(): Supplier
    {
        return $this->supplier;
    }
}
