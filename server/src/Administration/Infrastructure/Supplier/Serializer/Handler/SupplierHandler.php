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

namespace Administration\Infrastructure\Supplier\Serializer\Handler;

use Administration\Application\Supplier\ReadModel\Supplier;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\JsonSerializationVisitor;

class SupplierHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods(): array
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => Supplier::class,
                'method' => 'serialize',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => Supplier::class,
                'method' => 'deserialize',
            ],
        ];
    }

    public function serialize(JsonSerializationVisitor $visitor, Supplier $supplier, array $type): array
    {
        $data = [
            'uuid' => $supplier->uuid(),
            'name' => $supplier->name(),
            'fullAddress' => $supplier->fullAddress(),
            'phone' => $supplier->phone(),
            'facsimile' => $supplier->facsimile(),
            'email' => $supplier->email(),
            'contact' => $supplier->contact(),
            'cellphone' => $supplier->cellphone(),
            'familyLog' => $supplier->familyLog(),
            'delayDelivery' => $supplier->delayDelivery(),
            'orderDays' => $supplier->orderDays(),
            'slug' => $supplier->slug(),
        ];

        return $visitor->visitArray($data, $type);
    }

    public function deserialize(JsonDeserializationVisitor $visitor, array $data): Supplier
    {
        return new Supplier(
            $data['uuid'],
            $data['name'],
            $data['address'],
            $data['zipCode'],
            $data['town'],
            $data['country'],
            $data['phone'],
            $data['facsimile'],
            $data['email'],
            $data['contact'],
            $data['cellphone'],
            $data['familyLog'],
            $data['delayDelivery'],
            $data['orderDays'],
            $data['slug'],
        );
    }
}
