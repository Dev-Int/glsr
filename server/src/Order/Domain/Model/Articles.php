<?php

namespace Order\Domain\Model;

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

    public function add(Article $article): void
    {
        $this->values[] = $article;
    }
}
