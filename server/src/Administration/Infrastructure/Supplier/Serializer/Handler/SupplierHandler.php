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

use Administration\Application\Supplier\ReadModel\Supplier as SupplierReadModel;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;

class SupplierHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods(): array
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => SupplierReadModel::class,
                'method' => 'serialize',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => SupplierReadModel::class,
                'method' => 'deserialize',
            ],
        ];
    }

    public function serialize(
        JsonSerializationVisitor $visitor,
        SupplierReadModel $supplier,
        array $type
    ): array {
        $data = [
            'uuid' => $supplier->uuid,
            'name' => $supplier->name,
            'fullAddress' => $supplier->fullAddress(),
            'address' => $supplier->address,
            'zipCode' => $supplier->zipCode,
            'town' => $supplier->town,
            'country' => $supplier->country,
            'phone' => $supplier->phone,
            'facsimile' => $supplier->facsimile,
            'email' => $supplier->email,
            'contactName' => $supplier->contact,
            'cellPhone' => $supplier->cellphone,
            'familyLog' => $supplier->familyLog,
            'familyLogId' => $supplier->familyLogId,
            'delayDelivery' => $supplier->delayDelivery,
            'orderDays' => $supplier->orderDays,
            'active' => $supplier->active,
        ];

        return $visitor->visitArray($data, $type);
    }
}
