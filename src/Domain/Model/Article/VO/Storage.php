<?php

declare(strict_types=1);

namespace Domain\Model\Article\VO;

use Domain\Model\Common\InvalidQuantity;

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

    /**
     * @var string
     */
    private $unit;

    /**
     * @var float
     */
    private $quantity;

    /**
     * Storage constructor.
     *
     * @param string $unit
     * @param float  $quantity
     */
    public function __construct(string $unit, float $quantity)
    {
        $this->unit = $unit;
        $this->quantity = $quantity;
    }

    public static function fromArray(array $storage): self
    {
        $unit = static::unit($storage[0]);
        $quantity = static::quantity($storage[1]);

        return new self($unit, $quantity);
    }

    /**
     * Test the unit.
     *
     * @param string $unit
     *
     * @return string
     */
    private static function unit(string $unit): string
    {
        if (!in_array(strtolower($unit), self::UNITS)) {
            throw new InvalidUnit();
        }

        return strtolower($unit);
    }

    /**
     * Test the quantity.
     *
     * @param float $quantity
     *
     * @return float
     */
    private static function quantity(float $quantity): float
    {
        if (!is_float($quantity)) {
            throw new InvalidQuantity();
        }

        return $quantity;
    }

    public function toArray(): array
    {
        return [$this->unit, $this->quantity];
    }
}
