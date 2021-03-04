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
