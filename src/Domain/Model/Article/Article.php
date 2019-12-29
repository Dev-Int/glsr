<?php

declare(strict_types=1);

namespace Domain\Model\Article;

use Doctrine\Common\Collections\ArrayCollection;
use Domain\Model\Article\Entities\ZoneStorage;
use Domain\Model\Article\VO\Packaging;
use Domain\Model\Common\Entities\FamilyLog;
use Domain\Model\Common\Entities\Taxes;
use Domain\Model\Common\VO\NameField;
use Domain\Model\Supplier\Supplier;

/**
 * Article.
 *
 * @category Entity
 */
class Article
{
    /**
     * @var int
     */
    protected $articleId;

    /**
     * @var string Name of article
     */
    protected $name;

    /**
     * @var string Name of supplier
     */
    protected $supplier;

    /**
     * @var array Packaging (subdivision of parcel)
     */
    protected $packaging;

    /**
     * @var float Price of article
     */
    protected $price;

    /**
     * @var string Rate of VAT
     */
    protected $taxes;

    /**
     * @var float Quantity in stock
     */
    protected $quantity;

    /**
     * @var float Minimum stock
     */
    protected $minStock;

    /**
     * @var ArrayCollection Storage area(s)
     */
    protected $zoneStorages;

    /**
     * @var string Logistics family
     */
    protected $familyLog;

    /**
     * @var bool Active/Inactive
     */
    protected $active;

    /**
     * @var string
     */
    protected $slug;

    /**
     * Article constructor.
     *
     * @param NameField  $name
     * @param Supplier   $supplier
     * @param Packaging  $packaging
     * @param float      $price
     * @param Taxes      $taxes
     * @param float      $minStock
     * @param array      $zoneStorages
     * @param FamilyLog  $familyLog
     * @param float|null $quantity
     * @param bool|null  $active
     */
    public function __construct(
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
        $this->name = $name->getValue();
        $this->supplier = $supplier->name();
        $this->packaging = $packaging;
        $this->price = $price;
        $this->taxes = $taxes->name();
        $this->quantity = $quantity;
        $this->minStock = $minStock;
        $this->zoneStorages = new ArrayCollection($this->makeZoneStorageEntities($zoneStorages));
        $this->familyLog = $familyLog->path();
        $this->active = $active;
        $this->slug = $name->slugify();
    }

    /**
     * Create an Article.
     *
     * @param NameField $name
     * @param Supplier  $supplier
     * @param Packaging $packaging
     * @param float     $price
     * @param Taxes     $taxes
     * @param float     $minStock
     * @param array     $zoneStorages
     * @param FamilyLog $familyLog
     *
     * @return Article
     */
    public static function create(
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

    final public function renameArticle(NameField $name): void
    {
        $this->name = $name->getValue();
        $this->slug = $name->slugify();
    }

    /**
     * @param array $zoneStorages
     *
     * @return ZoneStorage[]
     */
    private function makeZoneStorageEntities(array $zoneStorages): array
    {
        return array_map(static function ($zone) {
            return new ZoneStorage(NameField::fromString($zone));
        }, $zoneStorages);
    }
}
