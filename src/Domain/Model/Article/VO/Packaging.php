<?php

declare(strict_types=1);

namespace Domain\Model\Article\VO;

final class Packaging
{
    /**
     * @var array
     */
    private $parcel;

    /**
     * @var array|null
     */
    private $subPackage;

    /**
     * @var array|null
     */
    private $consumerUnit;

    /**
     * Packaging constructor.
     *
     * @param array      $parcel
     * @param array|null $subPackage
     * @param array|null $consumerUnit
     */
    public function __construct(array $parcel, ?array $subPackage = null, ?array $consumerUnit = null)
    {
        $this->parcel = $parcel;
        $this->subPackage = $subPackage;
        $this->consumerUnit = $consumerUnit;
    }

    /**
     * @param array $packages
     *
     * @return Packaging
     */
    public static function fromArray(array $packages): self
    {
        $parcel = Storage::fromArray($packages[0])->toArray();
        $subPackage = null;
        $consumerUnit = null;

        for ($iteration = 1; $iteration < 3; ++$iteration) {
            if (null !== $packages[$iteration]) {
                if (1 == $iteration) {
                    $subPackage = Storage::fromArray($packages[$iteration])->toArray();
                }
                if (2 == $iteration) {
                    $consumerUnit = Storage::fromArray($packages[$iteration])->toArray();
                }
            }
        }

        return new self($parcel, $subPackage, $consumerUnit);
    }

    public function parcel(): array
    {
        return $this->parcel;
    }

    public function subPackage(): ?array
    {
        return $this->subPackage;
    }

    public function consumerUnit(): ?array
    {
        return $this->consumerUnit;
    }
}
