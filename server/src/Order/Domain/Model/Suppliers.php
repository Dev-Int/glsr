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

use ArrayIterator;
use Core\Domain\Protocol\Collection;
use Order\Domain\Exception\SupplierNotFound;

final class Suppliers implements Collection
{
    /**
     * @var Supplier[]
     */
    private array $values;

    public function __construct(...$articles)
    {
        $this->values = $articles;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->values);
    }

    /**
     * @return Supplier[]
     */
    public function toArray(): array
    {
        return $this->values;
    }

    public function getFromName(string $name): Supplier
    {
        foreach ($this->toArray() as $supplier) {
            if ($name === $supplier->name()) {
                return $supplier;
            }
        }

        throw new SupplierNotFound();
    }

    public function add(Supplier $supplier): void
    {
        $this->values[] = $supplier;
    }
}
