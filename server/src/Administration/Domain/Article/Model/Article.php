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

namespace Administration\Domain\Article\Model;

use Administration\Domain\Article\Model\Dependent\ZoneStorage;
use Administration\Domain\Article\Model\VO\ArticleUuid;
use Administration\Domain\Article\Model\VO\Packaging;
use Administration\Domain\FamilyLog\Model\FamilyLog;
use Administration\Domain\Supplier\Model\Supplier;
use Core\Domain\Common\Model\Dependent\Taxes;
use Core\Domain\Common\Model\VO\NameField;

final class Article
{
    private string $uuid;
    private string $name;
    private string $supplier;
    private Packaging $packaging;
    private float $price;
    private string $taxes;
    private float $quantity;
    private float $minStock;

    /**
     * @var ZoneStorage[]
     */
    private array $zoneStorages;
    private string $familyLog;
    private bool $active;
    private string $slug;

    public function __construct(
        ArticleUuid $uuid,
        NameField $name,
        Supplier $supplier,
        Packaging $packaging,
        float $price,
        Taxes $taxes,
        float $minStock,
        array $zoneStorages,
        FamilyLog $familyLog,
        ?float $quantity = 0.000,
        ?bool $active = true
    ) {
        $this->uuid = $uuid->toString();
        $this->name = $name->getValue();
        $this->supplier = $supplier->name();
        $this->packaging = $packaging;
        $this->price = $price;
        $this->taxes = $taxes->name();
        $this->quantity = $quantity ?? 0.000;
        $this->minStock = $minStock;
        $this->zoneStorages = $zoneStorages;
        $this->familyLog = $familyLog->path();
        $this->active = $active ?? true;
        $this->slug = $name->slugify();
    }

    /**
     * @param ZoneStorage[] $zoneStorages
     */
    public static function create(
        ArticleUuid $uuid,
        NameField $name,
        Supplier $supplier,
        Packaging $packaging,
        float $price,
        Taxes $taxes,
        float $minStock,
        array $zoneStorages,
        FamilyLog $familyLog
    ): self {
        return new self(
            $uuid,
            $name,
            $supplier,
            $packaging,
            $price,
            $taxes,
            $minStock,
            $zoneStorages,
            $familyLog
        );
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function supplier(): string
    {
        return $this->supplier;
    }

    public function packaging(): Packaging
    {
        return $this->packaging;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function taxes(): string
    {
        return $this->taxes;
    }

    public function quantity(): float
    {
        return $this->quantity;
    }

    public function minStock(): float
    {
        return $this->minStock;
    }

    /**
     * @return ZoneStorage[]
     */
    public function zoneStorages(): array
    {
        return $this->zoneStorages;
    }

    public function familyLog(): string
    {
        return $this->familyLog;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function renameArticle(NameField $name): void
    {
        $this->name = $name->getValue();
        $this->slug = $name->slugify();
    }
}
