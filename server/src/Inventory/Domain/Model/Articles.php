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

namespace Inventory\Domain\Model;

use ArrayIterator;
use Core\Domain\Protocol\Collection;

final class Articles implements Collection
{
    /**
     * @var Article[]
     */
    private array $values;

    public function __construct(...$articles)
    {
        $this->values = $articles;
    }

    public function add(Article $article): void
    {
        $this->values[] = $article;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->values);
    }

    /**
     * @return Article[]
     */
    public function toArray(): array
    {
        return $this->values;
    }
}
