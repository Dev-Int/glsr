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

namespace Order\Domain\Model\VO;

use Order\Domain\Exception\InvalidOrderDate;

final class OrderDate
{
    private \DateTimeImmutable $date;

    public function __construct(\DateTimeImmutable $date, array $orderDays)
    {
        if (false === \in_array((int) \date_format($date, 'w'), $orderDays, true)) {
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
