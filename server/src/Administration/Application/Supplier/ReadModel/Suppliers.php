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

namespace Administration\Application\Supplier\ReadModel;

use Administration\Application\Protocol\Collection\CollectionProtocol;

final class Suppliers implements CollectionProtocol
{
    /**
     * @var Supplier[]
     */
    private array $values;

    public function __construct(Supplier ...$suppliers)
    {
        $this->values = $suppliers;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->values);
    }

    public function toArray(): array
    {
        return $this->values;
    }
}
