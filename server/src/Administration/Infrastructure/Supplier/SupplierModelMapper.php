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

namespace Administration\Infrastructure\Supplier;

use Administration\Application\Supplier\ReadModel\Supplier as SupplierModel;
use Administration\Application\Supplier\ReadModel\Supplier as SupplierReadModel;
use Administration\Domain\Supplier\Model\Supplier;
use Core\Domain\Common\Model\Dependent\FamilyLog;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;

class SupplierModelMapper
{
    public function getReadModelFromArray(array $data): SupplierReadModel
    {
        return new SupplierModel(
            $data['uuid'],
            $data['name'],
            $data['address'],
            $data['zip_code'],
            $data['town'],
            $data['country'],
            $data['phone'],
            $data['facsimile'],
            $data['email'],
            $data['contact_name'],
            $data['cellphone'],
            $data['family_log'],
            (int) $data['delay_delivery'],
            \explode(',', $data['order_days']),
            $data['slug'],
            $data['active']
        );
    }

    public function getDomainModelFromArray(array $data): Supplier
    {
        return Supplier::create(
            ContactUuid::fromString($data['uuid']),
            NameField::fromString($data['name']),
            $data['address'],
            $data['zip_code'],
            $data['town'],
            $data['country'],
            PhoneField::fromString($data['phone']),
            PhoneField::fromString($data['facsimile']),
            EmailField::fromString($data['email']),
            $data['contact_name'],
            PhoneField::fromString($data['cellphone']),
            FamilyLog::create(NameField::fromString($data['family_log'])),
            (int) $data['delay_delivery'],
            \explode(',', $data['order_days']),
        );
    }

    public function getDataFromSupplier(Supplier $supplier): array
    {
        return [
            'uuid' => $supplier->uuid(),
            'name' => $supplier->name(),
            'address' => $supplier->address(),
            'zip_code' => $supplier->zipCode(),
            'town' => $supplier->town(),
            'country' => $supplier->country(),
            'phone' => $supplier->phone(),
            'facsimile' => $supplier->facsimile(),
            'email' => $supplier->email(),
            'contact_name' => $supplier->contact(),
            'cellphone' => $supplier->cellphone(),
            'family_log' => $supplier->familyLog(),
            'delay_delivery' => $supplier->delayDelivery(),
            'order_days' => \implode(',', $supplier->orderDays()),
            'slug' => $supplier->slug(),
            'active' => (int) $supplier->isActive(),
        ];
    }
}
