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

use Inventory\Domain\Model\VO\InventoryDate;

final class Inventory
{
    private \DateTimeImmutable $inventoryDate;
    private Articles $articles;

    public function __construct(InventoryDate $date, Articles $articles)
    {
        $this->inventoryDate = $date->getValue();
        $this->articles = $articles;
    }

    public static function prepare(InventoryDate $date, Articles $articles): self
    {
        return new self($date, $articles);
    }

    public function articles(): Articles
    {
        return $this->articles;
    }

    public function getGaps(?string $order = 'gap'): array
    {
        $gaps = [];
        foreach ($this->articles->toArray() as $article) {
            if (null !== $article->gap()) {
                $gaps[] = $article->gap();
            }
        }

        \usort($gaps, static function ($gapA, $gapB) use ($order) {
            if ($gapA[$order] === $gapB[$order]) {
                return 0;
            }

            return $gapA[$order] > $gapB[$order] ? 1 : -1;
        });

        return $gaps;
    }
}
