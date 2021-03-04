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

namespace Order\Domain\UseCase;

use Order\Domain\Model\Order;

final class EnterOrder
{
    public function execute(Order $order, array $data): void
    {
        $articles = $order->articles()->toArray();

        foreach ($data as $datum) {
            foreach ($articles as $article) {
                if ($article->label() === $datum['label']) {
                    $article->updateOrderedQuantity($datum['quantityToOrder']);
                }
            }
        }
    }
}
