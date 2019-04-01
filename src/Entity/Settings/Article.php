<?php

/**
 * Entity Article.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @see https://github.com/Dev-Int/glsr
 */

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
 * Article.
 *
 * @category Entity
 *
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
     *     message="The title can only contain letters,
     * digits and _ or -"
     * )
     */
    private $name;

    /**
     * @var string|\App\Entity\Settings\Supplier Name of supplier
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Supplier", inversedBy="articles")
     */
    private $supplier;

    /**
     * @var string|\App\Entity\Settings\Diverse\Unit Storage unit
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\Unit")
     */
    private $unitStorage;

    /**
     * @var string|\App\Entity\Settings\Diverse\Unit Working unit
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\Unit")
     */
    private $unitWorking;

    /**
     * @var float Packaging (quantity)
     *
     * @ORM\Column(name="packaging", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric",
     * message="The value {{value}} is not a valid type {{type}}.")
     */
    private $packaging;

    /**
     * @var float price of the article
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric",
     * message="The value {{value}} is not a valid type {{type}}.")
     */
    private $price;

    /**
     * @var string|\App\Entity\Settings\Diverse\Tva VAT rate
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\Tva")
     */
    private $tva;

    /**
     * @var float Quantity in stock
     *
     * @ORM\Column(name="quantity", type="decimal", precision=7, scale=3, nullable=true, options={"default":0})
     * @Assert\Type(type="numeric",
     * message="The value {{value}} is not a valid type {{type}}.")
     */
    private $quantity;

    /**
     * @var float Minimum stock
     *
     * @ORM\Column(name="minstock", type="decimal", precision=7, scale=3)
     * @Assert\Type(type="numeric",
     * message="The value {{value}} is not a valid type {{type}}.")
     */
    private $minstock;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection Storage area (s)
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Settings\Diverse\ZoneStorage")
     * @ORM\JoinTable(name="app_article_zonestorage")
     * @Assert\NotBlank()
     */
    private $zoneStorages;

    /**
     * @var string|\App\Entity\Settings\Diverse\FamilyLog Logistic family
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
     * @var \DateTimeInterface Created date
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;

    /**
     * @var \DateTimeInterface|null Updated date
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @var \DateTimeInterface|null Deleted date
     * @ORM\Column(name="delete_at", type="datetime", nullable=true)
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
        $this->createAt = new \DateTime();
        $this->deleteAt = new \DateTime('3000-12-31');
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name Article name
     *
     * @return Article
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set packaging.
     *
     * @param float $packaging Packaging (quantity)
     *
     * @return Article
     */
    public function setPackaging($packaging)
    {
        $this->packaging = $packaging;

        return $this;
    }

    /**
     * Get packaging.
     *
     * @return float
     */
    public function getPackaging()
    {
        return $this->packaging;
    }

    /**
     * Set price.
     *
     * @param float $price price of the article
     *
     * @return Article
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity.
     *
     * @param float $quantity quantity in stock
     *
     * @return Article
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set minstock.
     *
     * @param float $minstock Minimum stock
     *
     * @return Article
     */
    public function setMinstock($minstock)
    {
        $this->minstock = $minstock;

        return $this;
    }

    /**
     * Get minstock.
     *
     * @return float
     */
    public function getMinstock()
    {
        return $this->minstock;
    }

    /**
     * Set supplier.
     *
     * @param \App\Entity\Settings\Supplier|null $supplier Supplier of the article
     *
     * @return Article
     */
    public function setSupplier(Supplier $supplier = null)
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier.
     *
     * @return string|\App\Entity\Settings\Supplier
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Set unitStorage.
     *
     * @param \App\Entity\Settings\Diverse\Unit|null $unitStorage Storage unit
     *
     * @return Article
     */
    public function setUnitStorage(Unit $unitStorage = null)
    {
        $this->unitStorage = $unitStorage;

        return $this;
    }

    /**
     * Get unitStorage.
     *
     * @return string|\App\Entity\Settings\Diverse\Unit
     */
    public function getUnitStorage()
    {
        return $this->unitStorage;
    }

    /**
     * Add zoneStorage.
     *
     * @param \App\Entity\Settings\Diverse\ZoneStorage
     * $zoneStorages Stockage area (s)
     *
     * @return Article
     */
    public function addZoneStorage(ZoneStorage $zoneStorages)
    {
        $this->zoneStorages[] = $zoneStorages;

        return $this;
    }

    /**
     * Remove zoneStorage.
     *
     * @param \App\Entity\Settings\Diverse\ZoneStorage $zoneStorages Storage area to delete
     *
     * @return \Doctrine\Common\Collections\ArrayCollection|null
     */
    public function removeZoneStorage(ZoneStorage $zoneStorages)
    {
        $this->zoneStorages->removeElement($zoneStorages);
    }

    /**
     * Get zoneStorage.
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getZoneStorages()
    {
        return $this->zoneStorages;
    }

    /**
     * Set unitWorking.
     *
     * @param \App\Entity\Settings\Diverse\Unit $unitWorking
     *
     * @return Article
     */
    public function setUnitWorking(Unit $unitWorking = null)
    {
        $this->unitWorking = $unitWorking;

        return $this;
    }

    /**
     * Get unitWorking.
     *
     * @return \App\Entity\Settings\Diverse\UnitWorking
     */
    public function getUnitWorking()
    {
        return $this->unitWorking;
    }

    /**
     * Set familyLog.
     *
     * @param \App\Entity\Settings\Diverse\FamilyLog|null $familyLog Logistic family
     *
     * @return Article
     */
    public function setFamilyLog(FamilyLog $familyLog = null)
    {
        $this->familyLog = $familyLog;

        return $this;
    }

    /**
     * Get familyLog.
     *
     * @return \App\Entity\Settings\Diverse\FamilyLog
     */
    public function getFamilyLog()
    {
        return $this->familyLog;
    }

    /**
     * Set tva.
     *
     * @param \App\Entity\Settings\Diverse\Tva $tva
     *
     * @return Article
     */
    public function setTva(Tva $tva = null)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva.
     *
     * @return \App\Entity\Settings\Diverse\Tva
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set active.
     *
     * @param bool $active On / Off
     *
     * @return Article
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * This method allows to make "echo $article".
     * <p> So, to "show" $article,
     * PHP will actually show the return of this method. <br />
     * Here, the name, so "echo $article"
     * is equivalent to "echo $article->getName()". </p>.
     *
     * @return string name
     */
    public function __toString()
    {
        return $this->name;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get Create at.
     *
     * @return \DateTimeInterface
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get Update at.
     *
     * @return \DateTimeInterface
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get Delete at.
     *
     * @return \DateTimeInterface
     */
    public function getDeleteAt()
    {
        return $this->deleteAt;
    }

    public function setDeleteAt(\DateTimeInterface $deleteAt = null): self
    {
        if (null === $deleteAt) {
            $this->deleteAt = new \DateTime();
            date_date_set($this->deleteAt, date('Y') + 4, 12, 31);
        } else {
            $this->deleteAt = $deleteAt;
        }

        return $this;
    }
}
