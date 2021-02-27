<?php

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
