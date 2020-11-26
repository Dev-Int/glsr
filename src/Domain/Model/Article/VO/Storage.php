<?php

declare(strict_types=1);

/*
 * This file is part of the Tests package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Domain\Model\Article\VO;

use Domain\Model\Common\Exception\InvalidQuantity;

final class Storage
{
    public const UNITS = [
        'bouteille',
        'boite',
        'carton',
        'colis',
        'kilogramme',
        'litre',
        'pièce',
        'poche',
        'portion',
    ];

    private string $unit;
    private float $quantity;

    public function __construct(string $unit, float $quantity)
    {
        $this->unit = $unit;
        $this->quantity = $quantity;
    }

    public static function fromArray(array $storage): self
    {
        $unit = static::isValidUnit($storage[0]);
        $quantity = static::isValidQuantity($storage[1]);

        return new self($unit, $quantity);
    }

    public function toArray(): array
    {
        return [$this->unit, $this->quantity];
    }

    private static function isValidUnit(string $unit): string
    {
        if (!\in_array(\strtolower($unit), self::UNITS, true)) {
            throw new InvalidUnit();
        }

        return \strtolower($unit);
    }

    private static function isValidQuantity(float $quantity): float
    {
        if (!\is_float($quantity)) {
            throw new InvalidQuantity();
        }

        return $quantity;
    }
}
