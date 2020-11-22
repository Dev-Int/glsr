<?php

namespace App\Entity\Settings;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Settings\Diverse\Unit;
use App\Entity\Settings\Diverse\Tva;
use App\Entity\Settings\Diverse\FamilyLog;
use App\Entity\Settings\Diverse\ZoneStorage;

/**
 * @ORM\Table(name="app_article")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\ArticleRepository")
 * @UniqueEntity(fields="name", message="This article name is already used.")
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{
    /**
     * @var int Id of the article
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string title of the article
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="'^\w+[^/]'",
     *     message="The title can only contain letters, digits and _ or -"
     * )
     */
    private $name;

    /**
     * @var string|Supplier Name of supplier
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Supplier")
     */
    private $supplier;

    /**
     * @var Unit Storage unit
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\Unit")
     */
    private $unitStorage;

    /**
     * @var Unit Working unit
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\Unit")
     */
    private $unitWorking;

    /**
     * @var double Packaging (quantity)
     *
     * @ORM\Column(name="packaging", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric",
     * message="The value {{value}} is not a valid type {{type}}.")
     */
    private $packaging;

    /**
     * @var double price of the article
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric",
     * message="The value {{value}} is not a valid type {{type}}.")
     */
    private $price;

    /**
     * @var string|Tva VAT rate
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\Tva")
     */
    private $tva;

    /**
     * @var double Quantity in stock
     *
     * @ORM\Column(name="quantity", type="decimal", precision=7, scale=3, nullable=true, options={"default":0})
     * @Assert\Type(type="numeric",
     * message="The value {{value}} is not a valid type {{type}}.")
     */
    private $quantity;

    /**
     * @var double Minimum stock
     *
     * @ORM\Column(name="minstock", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric",
     * message="The value {{value}} is not a valid type {{type}}.")
     */
    private $minStock;

    /**
     * @var ArrayCollection Storage area(s)
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Settings\Diverse\ZoneStorage")
     * @ORM\JoinTable(name="app_article_zonestorage")
     * @Assert\NotBlank()
     */
    private $zoneStorages;

    /**
     * @var string|FamilyLog Logistic family
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\FamilyLog")
     * @Assert\NotBlank()
     */
    private $familyLog;

    /**
     * @var bool On / Off
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var \DateTimeImmutable Created date
     * @ORM\Column(name="create_at", type="datetime_immutable")
     */
    private $createAt;

    /**
     * @var \DateTimeImmutable Updated date
     * @ORM\Column(name="update_at", type="datetime_immutable")
     */
    private $updateAt;

    /**
     * @var \DateTimeImmutable Deleted date
     * @ORM\Column(name="delete_at", type="datetime_immutable", nullable=true)
     */
    private $deleteAt;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->zoneStorages = new ArrayCollection();
        $this->active = true;
        $this->quantity = 0.000;
        $this->createAt = new \DateTimeImmutable() ;
        $this->updateAt = new \DateTimeImmutable() ;
        $this->deleteAt = new \DateTimeImmutable('3000-12-31') ;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setPackaging(float $packaging): self
    {
        $this->packaging = $packaging;

        return $this;
    }

    public function getPackaging(): float
    {
        return $this->packaging;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setMinStock(float $minStock): self
    {
        $this->minStock = $minStock;

        return $this;
    }

    public function getMinStock(): float
    {
        return $this->minStock;
    }

    public function setSupplier(Supplier $supplier = null): self
    {
        $this->supplier = $supplier;

        return $this;
    }

    public function getSupplier(): Supplier
    {
        return $this->supplier;
    }

    public function setUnitStorage(Unit $unitStorage = null): self
    {
        $this->unitStorage = $unitStorage;

        return $this;
    }

    public function getUnitStorage(): Unit
    {
        return $this->unitStorage;
    }

    public function addZoneStorage(ZoneStorage $zoneStorages): self
    {
        $this->zoneStorages[] = $zoneStorages;

        return $this;
    }

    public function removeZoneStorage(ZoneStorage $zoneStorages): void
    {
        $this->zoneStorages->removeElement($zoneStorages);
    }

    /**
     * @return ArrayCollection|ZoneStorage[]
     */
    public function getZoneStorages()
    {
        return $this->zoneStorages;
    }

    public function setUnitWorking(Unit $unitWorking = null): self
    {
        $this->unitWorking = $unitWorking;

        return $this;
    }

    public function getUnitWorking(): Unit
    {
        return $this->unitWorking;
    }

    public function setFamilyLog(FamilyLog $familyLog = null): self
    {
        $this->familyLog = $familyLog;

        return $this;
    }

    public function getFamilyLog(): FamilyLog
    {
        return $this->familyLog;
    }

    public function setTva(Tva $tva = null): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getTva(): Tva
    {
        return $this->tva;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreateAt(): \DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): \DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getDeleteAt(): \DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setDeleteAt(\DateTimeImmutable $deleteAt = null): self
    {
        if ($deleteAt === null) {
            $this->deleteAt = new \DateTimeImmutable();
            date_date_set($this->deleteAt, date('Y') + 4, 12, 31);
        } else {
            $this->deleteAt = $deleteAt;
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
