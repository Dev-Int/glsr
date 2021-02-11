<?php

declare(strict_types=1);

namespace Inventory\Domain\Model;

use Core\Domain\Protocol\Collection;
use ArrayIterator;

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
