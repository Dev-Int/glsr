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

final class Packaging
{
    private array $parcel;
    private ?array $subPackage;
    private ?array $consumerUnit;

    public function __construct(array $parcel, ?array $subPackage = null, ?array $consumerUnit = null)
    {
        $this->parcel = $parcel;
        $this->subPackage = $subPackage;
        $this->consumerUnit = $consumerUnit;
    }

    public static function fromArray(array $packages): self
    {
        $parcel = Storage::fromArray($packages[0])->toArray();
        $subPackage = null;
        $consumerUnit = null;

        for ($i = 1; $i < 3; ++$i) {
            if (null !== $packages[$i]) {
                if (1 === $i) {
                    $subPackage = Storage::fromArray($packages[$i])->toArray();
                }
                if (2 === $i) {
                    $consumerUnit = Storage::fromArray($packages[$i])->toArray();
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
