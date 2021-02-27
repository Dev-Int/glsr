<?php

namespace Order\Domain\Model;

final class Order
{
    private Supplier $supplier;
    private Articles $articles;

    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
        $this->articles = $supplier->articles();
    }

    public static function create(Supplier $supplier): self
    {
        return new self($supplier);
    }

    public function articles(): Articles
    {
        return $this->articles;
    }
}
