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

namespace Administration\Infrastructure\Company\Serializer\Handler;

use Administration\Domain\Company\Model\Company;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\JsonSerializationVisitor;

class CompanyHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods(): array
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => Company::class,
                'method' => 'serialize',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => Company::class,
                'method' => 'deserialize',
            ],
        ];
    }

    public function serialize(JsonSerializationVisitor $visitor, Company $company, array $type): array
    {
        $data = [
            'uuid' => $company->uuid(),
            'name' => $company->name(),
            'address' => $company->address(),
            'zipCode' => $company->zipCode(),
            'town' => $company->town(),
            'country' => $company->country(),
            'phone' => $company->phone(),
            'facsimile' => $company->facsimile(),
            'email' => $company->email(),
            'contact' => $company->contact(),
            'cellphone' => $company->cellphone(),
            'slug' => $company->slug(),
        ];

        return $visitor->visitArray($data, $type);
    }

    public function deserialize(JsonDeserializationVisitor $visitor, array $data): Company
    {
        return new Company(
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
        );
    }
}
