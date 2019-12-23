<?php

declare(strict_types=1);

namespace Domain\Model\Article\VO;

use Domain\Model\Common\InvalidQuantity;

class Storage
{
    public const UNITS = ['colis', 'carton', 'bouteille', 'boite', 'poche', 'pièce', 'portion', 'kilogramme', 'litre'];
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

    private static function unit(string $unit): string
    {
        if (!in_array(strtolower($unit), self::UNITS)) {
            throw new InvalidUnit();
        }

        return strtolower($unit);
    }

    private static function quantity(float $quantity): float
    {
        if (!is_float($quantity)) {
            throw new InvalidQuantity();
        }

        return $quantity;
    }

    final public function toArray(): array
    {
        return [$this->unit, $this->quantity];
    }
}
