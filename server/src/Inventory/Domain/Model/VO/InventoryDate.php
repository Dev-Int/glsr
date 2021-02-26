<?php

declare(strict_types=1);

namespace Inventory\Domain\Model\VO;

use Inventory\Domain\Exception\InvalidInventoryDate;

final class InventoryDate
{
    private \DateTimeImmutable $date;

    public function __construct(\DateTimeImmutable $date)
    {
        if (('Sunday' !== date_format($date, 'l')) || false === date("Y-m-t", $date->getTimestamp())) {
            throw new InvalidInventoryDate();
        }
        $this->date = $date;
    }

    public static function fromDate(\DateTimeImmutable $date): self
    {
        return new self($date);
    }

    public function getValue(): \DateTimeImmutable
    {
        return $this->date;
    }
}
