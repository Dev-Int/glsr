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

namespace Inventory\Domain\UseCase;

use Inventory\Domain\Model\Article;
use Inventory\Domain\Model\Articles;
use Inventory\Domain\Model\Inventory;
use Inventory\Domain\Model\VO\InventoryDate;

final class PrepareInventory
{
    public function execute(\DateTimeImmutable $date): Inventory
    {
        // get Articles
        $articles = new Articles(
            Article::create('tomato', 5.00, 0.85),
            Article::create('carotte', 0.00, 0.53),
            Article::create('potato', 0.00, 0.27),
        );

        return Inventory::prepare(InventoryDate::fromDate($date), $articles);
    }
}
