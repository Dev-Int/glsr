<?php

namespace Order\Domain\Model;

final class Order
{
    private Supplier $supplier;
    private Articles $articles;
    private \DateTimeImmutable $orderDate;

    public function __construct(Supplier $supplier, \DateTimeImmutable $orderDate)
    {
        $this->supplier = $supplier;
        $this->articles = $supplier->articles();
        $this->orderDate = $orderDate;
    }

    public static function create(Supplier $supplier, \DateTimeImmutable $orderDate): self
    {
        return new self($supplier, $orderDate);
    }

    public function articles(): Articles
    {
        return $this->articles;
    }
}
