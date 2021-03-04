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

use Inventory\Domain\Model\Inventory;

final class EnterInventory
{
    public function execute(Inventory $inventory, array $data): void
    {
        $articles = $inventory->articles();

        foreach ($data as $datum) {
            foreach ($articles->toArray() as $article) {
                if ($article->label() === $datum['label']) {
                    $article->updateStock($datum['stock']);
                }
            }
        }
    }
}
