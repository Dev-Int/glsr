<?php

declare(strict_types=1);

namespace Order\Domain\Model\VO;

use Order\Domain\Exception\InvalidOrderDate;

final class OrderDate
{
    private \DateTimeImmutable $date;

    public function __construct(\DateTimeImmutable $date, array $orderDays)
    {
        if (false === \in_array((int) date_format($date, 'w'), $orderDays, true)) {
            throw new InvalidOrderDate();
        }
        $this->date = $date;
    }

    public static function fromDate(\DateTimeImmutable $date, array $orderDays): self
    {
        return new self($date, $orderDays);
    }

    public function getValue(): \DateTimeImmutable
    {
        return $this->date;
    }
}
