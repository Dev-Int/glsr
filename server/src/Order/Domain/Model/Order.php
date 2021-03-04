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
