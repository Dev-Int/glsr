<?php

declare(strict_types=1);

namespace Domain\Model\Article;

use Doctrine\Common\Collections\ArrayCollection;
use Domain\Model\Article\Entities\ZoneStorage;
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
    private $id;

    /**
     * @var string intitulé de l'article
     */
    private $name;

    /**
     * @var string Nom du fournisseur
     */
    private $supplier;

    /**
     * @var string Unité de stockage
     */
    private $unitStorage;

    /**
     * @var float Conditionement (quantité)
     */
    private $packaging;

    /**
     * @var float prix de l'article
     */
    private $price;

    /**
     * @var string Taux de TVA
     */
    private $tva;

    /**
     * @var float Quantité en stock
     */
    private $quantity;

    /**
     * @var float Stock minimum
     */
    private $minStock;

    /**
     * @var ArrayCollection Zone(s) de stockage
     */
    private $zoneStorages;

    /**
     * @var string Famille logistique
     */
    private $familyLog;

    /**
     * @var bool Activé/Désactivé
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string
     */
    private $slug;

    /**
     * Article constructor.
     * @param NameField $name
     * @param Supplier $supplier
     * @param string $unitStorage
     * @param float $packaging
     * @param float $price
     * @param string $tva
     * @param float $minStock
     * @param array $zoneStorages
     * @param string $familyLog
     * @param float|null $quantity
     * @param bool|null $active
     */
    public function __construct(
        NameField $name,
        Supplier $supplier,
        string $unitStorage,
        float $packaging,
        float $price,
        string $tva,
        float $minStock,
        array $zoneStorages,
        string $familyLog,
        ?float $quantity = 0.000,
        ?bool $active = true
    ) {
        $this->name = $name->getValue();
        $this->supplier = $supplier->name();
        $this->unitStorage = $unitStorage;
        $this->packaging = $packaging;
        $this->price = $price;
        $this->tva = $tva;
        $this->quantity = $quantity;
        $this->minStock = $minStock;
        $this->zoneStorages = new ArrayCollection($this->makeZoneStorageEntities($zoneStorages));
        $this->familyLog = $familyLog;
        $this->active = $active;
        $this->slug = $name->slugify();
    }

    /**
     * @param NameField $name
     * @param Supplier $supplier
     * @param string $unitStorage
     * @param float $packaging
     * @param float $price
     * @param string $tva
     * @param float $minStock
     * @param array $zoneStorages
     * @param string $familyLog
     * @return Article
     */
    public static function create(
        NameField $name,
        Supplier $supplier,
        string $unitStorage,
        float $packaging,
        float $price,
        string $tva,
        float $minStock,
        array $zoneStorages,
        string $familyLog
    ): self {
        return new self(
            $name,
            $supplier,
            $unitStorage,
            $packaging,
            $price,
            $tva,
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
     * @return ZoneStorage[]
     */
    private function makeZoneStorageEntities(array $zoneStorages): array
    {
        return array_map(static function ($zone) {
            return new ZoneStorage(NameField::fromString($zone));
        }, $zoneStorages);
    }
}
