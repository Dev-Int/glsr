<?php

declare(strict_types=1);

namespace Order\Domain\UseCase;

use Order\Domain\Model\Order;
use Order\Domain\Model\Supplier;

final class CreateOrder
{
    public function execute(Supplier $supplier, \DateTimeImmutable $orderDate): Order
    {
        return Order::create($supplier, $orderDate);
    }
}
