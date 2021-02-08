<?php

declare(strict_types=1);

namespace App\Domain\Protocol;

use ArrayIterator;

interface Collection
{
    public function getIterator(): ArrayIterator;

    public function toArray(): array;
}
